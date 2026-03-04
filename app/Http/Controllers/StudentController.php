<?php

namespace App\Http\Controllers;

use App\Models\BrushingLog;
use App\Models\EducationalMaterial;
use App\Models\User;
use App\Models\Student;
use App\Models\ScreeningResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $materials = EducationalMaterial::all();

        // Pre-test dan Post-test sekarang bebas diakses berulang kali
        // Modals tidak akan dimunculkan secara paksa lagi.
        $hasPreTest = true; 
        $shouldShowPostTest = false;

        return view('student.dashboard', compact('hasPreTest', 'shouldShowPostTest', 'materials'));
    }

    /**
     * Menampilkan daftar pasien untuk Lecturer
     */
    public function index()
    {
        // Menggunakan pagination agar performa tetap baik saat data banyak
        $students = Student::with('user')
            ->latest()
            ->paginate(15);

        return view('lecturer.datapasien', compact('students'));
    }

    /**
     * Simpan data pasien baru (Pendaftaran oleh Lecturer)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Data User (Tabel: users)
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',

            // Data Student (Tabel: students)
            'nik' => 'required|string|unique:students,nik|max:16',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female',
            'address' => 'required|string',
            'education' => 'nullable|in:SD,SMP,SMA,Perguruan Tinggi',
            'trimester' => 'nullable|in:I,II,III',
            'pregnancy_week' => 'nullable|integer|between:0,50',
            'last_period_date' => 'nullable|date',
        ]);

        try {
            return DB::transaction(function () use ($validated) {
                // 1. Generate Password Acak
                $passwordPlain = Str::random(8);
                $phoneForDb = preg_replace('/^\+62/', '0', $validated['phone']);

                // 2. Create User (Akun Login)
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $phoneForDb,
                    'password' => Hash::make($passwordPlain),
                    'role' => 'student', // Sesuaikan dengan helper isStudent() di model
                ]);

                // 3. Create Student Profile
                $user->student()->create([
                    'nik' => $validated['nik'],
                    'dob' => $validated['dob'],
                    'gender' => $validated['gender'],
                    'address' => $validated['address'],
                    'education' => $validated['education'],
                    'trimester' => $validated['trimester'],
                    'pregnancy_week' => $validated['pregnancy_week'],
                    'last_period_date' => $validated['last_period_date'],
                ]);

                // 4. Kirim WhatsApp (Fonnte)
                $this->sendWhatsAppCredentials($user, $passwordPlain);

                return response()->json([
                    'success' => true,
                    'message' => 'Pasien berhasil didaftarkan!',
                    'credentials' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'password' => $passwordPlain,
                        'phone' => $validated['phone']
                    ]
                ]);
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update data pasien
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $user = $student->user;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user->id}",
            'phone' => "required|string|max:20",
            'nik' => "required|string|unique:students,nik,{$student->id}",
            'dob' => 'required|date',
            'address' => 'required|string',
            'trimester' => 'nullable|string',
            'pregnancy_week' => 'nullable|integer',
        ]);

        try {
            DB::transaction(function () use ($validated, $user, $student, $request) {
                // Update User
                $user->update([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                ]);

                // Update Student
                $student->update($request->only([
                    'nik',
                    'dob',
                    'gender',
                    'address',
                    'education',
                    'trimester',
                    'pregnancy_week',
                    'last_period_date'
                ]));
            });

            return response()->json(['success' => true, 'message' => 'Data pasien berhasil diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal update: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Hapus Pasien & Akun User
     */
    public function destroy($id)
    {
        try {
            $student = Student::findOrFail($id);
            $user = $student->user;

            DB::transaction(function () use ($user, $student) {
                // Hapus avatar jika ada
                if ($user->avatar_url) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $user->avatar_url));
                }

                $student->delete();
                $user->delete();
            });

            return response()->json(['success' => true, 'message' => 'Data pasien dan akun berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus data'], 500);
        }
    }

    /**
     * Helper kirim WA
     */
    private function sendWhatsAppCredentials($user, $password)
    {
        $token = env('FONNTE_TOKEN');
        $message = "Halo Ibu {$user->name},\n\nAkun MindScans Anda telah aktif.\n\nLogin: {$user->email}\nPassword: {$password}\n\nSilakan login untuk memantau kesehatan gigi dan kehamilan Anda.";

        return Http::withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/send', [
            'target' => $user->phone,
            'message' => $message,
        ]);
    }
}
