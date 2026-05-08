<?php

namespace App\Http\Controllers;

use App\Models\BrushingLog;
use App\Models\User;
use App\Models\Biodata;
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
        // Pre-test dan Post-test sekarang bebas diakses berulang kali
        // Modals tidak akan dimunculkan secara paksa lagi.
        $hasPreTest = true; 
        $shouldShowPostTest = false;

        return view('student.dashboard', compact('hasPreTest', 'shouldShowPostTest'));
    }

    /**
     * Menampilkan daftar mahasiswa untuk Lecturer
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $prodi = $request->input('prodi');

        $studentsQuery = User::where('sub_role', 'student')->with(['biodata', 'screeningResponses' => function($q) {
            $q->orderBy('created_at', 'desc');
        }]);

        $lecturerKampus = Auth::user()->biodata->nama_kampus ?? null;
        if ($lecturerKampus) {
            $studentsQuery->whereHas('biodata', function ($q) use ($lecturerKampus) {
                $q->where('nama_kampus', $lecturerKampus);
            });
        }

        if ($search) {
            $studentsQuery->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($prodi) {
            $studentsQuery->whereHas('biodata', function ($q) use ($prodi) {
                $q->where('prodi', 'like', "%{$prodi}%");
            });
        }

        // Get unique prodi list for the filter dropdown
        $prodiQuery = Biodata::whereHas('user', function($q) {
            $q->where('sub_role', 'student');
        })->whereNotNull('prodi');

        if ($lecturerKampus) {
            $prodiQuery->where('nama_kampus', $lecturerKampus);
        }
        $prodiList = $prodiQuery->distinct()->pluck('prodi');

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
        $message = "Halo {$user->name},\n\nAkun Anda telah aktif.\n\nLogin: {$user->email}\nPassword: {$password}\n\nSilakan login untuk memantau kesehatan mental Anda.";

        return Http::withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/send', [
            'target' => $user->phone,
            'message' => $message,
        ]);
    }
}
