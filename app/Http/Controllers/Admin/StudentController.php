<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = User::where('role', 'student')
            ->with('student')
            ->paginate(10);

        return view('admin.student.index', compact('students'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if ($user->role !== 'student') {
            abort(403, 'Unauthorized');
        }

        $user->load('student');

        return view('admin.student.show', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'phone' => 'nullable|string|max:20|unique:users,phone',
            'password' => 'required|min:8',

            'nim' => 'required|string|max:255|unique:students,nim',
            'kampus' => 'required|string|max:255',
            'jenjang' => 'required|string|max:255',
            'program_studi' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'status' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'] ?? null,
                'phone' => $data['phone'] ?? null,
                'password' => Hash::make($data['password']),
                'role' => 'student',
            ]);

            Student::create([
                'user_id' => $user->id,
                'nim' => $data['nim'],
                'kampus' => $data['kampus'],
                'jenjang' => $data['jenjang'],
                'program_studi' => $data['program_studi'],
                'gender' => $data['gender'],
                'status' => $data['status'],
            ]);
        });

        return response()->json([
            'message' => 'Mahasiswa berhasil ditambahkan'
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::with('student')->findOrFail($id);

        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => [
                    'nullable',
                    'email',
                    Rule::unique('users', 'email')->ignore($user->id)
                ],
                'phone' => [
                    'nullable',
                    'string',
                    'max:20',
                    Rule::unique('users', 'phone')->ignore($user->id)
                ],
                'nim' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('students', 'nim')->ignore($user->student?->id)
                ],
                'kampus' => 'required|string|max:255',
                'jenjang' => 'required|string|max:255',
                'program_studi' => 'required|string|max:255',
                'gender' => 'required|in:male,female',
                'status' => 'required|string|max:255',
            ]);

            DB::transaction(function () use ($user, $data) {
                $user->update([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                ]);

                if ($user->student) {
                    $user->student->update([
                        'nim' => $data['nim'],
                        'kampus' => $data['kampus'],
                        'jenjang' => $data['jenjang'],
                        'program_studi' => $data['program_studi'],
                        'gender' => $data['gender'],
                        'status' => $data['status'],
                    ]);
                } else {
                    Student::create([
                        'user_id' => $user->id,
                        'nim' => $data['nim'],
                        'kampus' => $data['kampus'],
                        'jenjang' => $data['jenjang'],
                        'program_studi' => $data['program_studi'],
                        'gender' => $data['gender'],
                        'status' => $data['status'],
                    ]);
                }
            });

            return response()->json([
                'message' => 'Data mahasiswa berhasil diperbarui'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal update mahasiswa: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::where('role', 'student')->findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'Data mahasiswa berhasil dihapus'
        ]);
    }
}
