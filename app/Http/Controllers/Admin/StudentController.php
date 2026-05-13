<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Biodata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = User::where('sub_role', 'student')->with('biodata');

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $students = $query->paginate(10);
        $students->appends(['search' => $search]);

        return view('admin.student.index', compact('students', 'search'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if ($user->sub_role !== 'student') {
            abort(403, 'Unauthorized');
        }

        $user->load('biodata');

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

            'kampus' => 'required|string|max:255',
            'program_studi' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'status' => 'required|string|max:255',
            'ttl' => 'nullable|date',
            'alamat_asal' => 'nullable|string',
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'] ?? null,
                'phone' => $data['phone'] ?? null,
                'password' => Hash::make($data['password']),
                'role' => 'responden',
                'sub_role' => 'student',
            ]);

            Biodata::create([
                'user_id' => $user->id,
                'nama_kampus' => $data['kampus'],
                'prodi' => $data['program_studi'],
                'jenis_kelamin' => $data['gender'],
                'status' => $data['status'],
                'ttl' => $data['ttl'] ?? null,
                'alamat_asal' => $data['alamat_asal'] ?? null,
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
        $user = User::with('biodata')->findOrFail($id);

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
                'kampus' => 'required|string|max:255',
                'program_studi' => 'required|string|max:255',
                'gender' => 'required|in:male,female',
                'status' => 'required|string|max:255',
                'ttl' => 'nullable|date',
                'alamat_asal' => 'nullable|string',
            ]);

            DB::transaction(function () use ($user, $data) {
                $user->update([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                ]);

                if ($user->biodata) {
                    $user->biodata->update([
                        'nama_kampus' => $data['kampus'],
                        'prodi' => $data['program_studi'],
                        'jenis_kelamin' => $data['gender'],
                        'status' => $data['status'],
                        'ttl' => $data['ttl'] ?? null,
                        'alamat_asal' => $data['alamat_asal'] ?? null,
                    ]);
                } else {
                    Biodata::create([
                        'user_id' => $user->id,
                        'nama_kampus' => $data['kampus'],
                        'prodi' => $data['program_studi'],
                        'jenis_kelamin' => $data['gender'],
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
        $user = User::where('sub_role', 'student')->findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'Data mahasiswa berhasil dihapus'
        ]);
    }
}
