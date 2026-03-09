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
     * Menampilkan daftar mahasiswa untuk Lecturer
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $prodi = $request->input('prodi');

        $studentsQuery = Student::with(['user', 'screenings' => function($q) {
            $q->orderBy('created_at', 'desc');
        }]);

        if ($search) {
            $studentsQuery->where(function($q) use ($search) {
                $q->whereHas('user', function($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%");
                })->orWhere('nim', 'like', "%{$search}%");
            });
        }

        if ($prodi) {
            $studentsQuery->where('program_studi', 'like', "%{$prodi}%");
        }

        // Get unique prodi list for the filter dropdown
        $prodiList = Student::whereNotNull('program_studi')->distinct()->pluck('program_studi');

        $students = $studentsQuery->latest()->paginate(15);
        
        // Append query strings so pagination links keep filters
        $students->appends(['search' => $search, 'prodi' => $prodi]);

        return view('lecturer.datamahasiswa', compact('students', 'search', 'prodi', 'prodiList'));
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
