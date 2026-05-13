<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLecturerRequest;
use App\Http\Requests\UpdateLecturerRequest;
use App\Models\User;
use App\Models\Biodata;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = User::with('biodata')->where('sub_role', 'lecturer');

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $lecturer = $query->latest()->paginate(10);
        $lecturer->appends(['search' => $search]);

        return view('admin.lecturer.index', compact('lecturer', 'search'));
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

            'gender' => 'required|in:male,female',
            'kampus' => 'required|string|max:255',
            'program_studi' => 'required|string|max:255',
            'jabatan_fungsional' => 'nullable|string|max:255',
            'ttl' => 'nullable|date',
            'alamat_asal' => 'nullable|string',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'status_ikatan_kerja' => 'nullable|string|max:255',
            'status_aktivitas' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($data) {

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'] ?? null,
                'phone' => $data['phone'] ?? null,
                'password' => Hash::make($data['password']),
                'role' => 'responden',
                'sub_role' => 'lecturer',
            ]);

            Biodata::create([
                'user_id' => $user->id,
                'jenis_kelamin' => $data['gender'],
                'nama_kampus' => $data['kampus'],
                'prodi' => $data['program_studi'],
                'status' => $data['status_aktivitas'] ?? null,
                'job_description' => $data['jabatan_fungsional'] ?? null,
                'ttl' => $data['ttl'] ?? null,
                'alamat_asal' => $data['alamat_asal'] ?? null,
            ]);
        });

        return response()->json([
            'message' => 'Tenaga kesehatan berhasil ditambahkan'
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
                'gender' => 'required|in:male,female',
                'kampus' => 'required|string|max:255',
                'program_studi' => 'required|string|max:255',
                'jabatan_fungsional' => 'nullable|string|max:255',
                'ttl' => 'nullable|date',
                'alamat_asal' => 'nullable|string',
                'pendidikan_terakhir' => 'nullable|string|max:255',
                'status_ikatan_kerja' => 'nullable|string|max:255',
                'status_aktivitas' => 'nullable|string|max:255',
            ]);

            DB::transaction(function () use ($user, $data) {
                $user->update([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                ]);

                if ($user->biodata) {
                    $user->biodata->update([
                        'jenis_kelamin' => $data['gender'],
                        'nama_kampus' => $data['kampus'],
                        'prodi' => $data['program_studi'],
                        'status' => $data['status_aktivitas'] ?? null,
                        'job_description' => $data['jabatan_fungsional'] ?? null,
                        'ttl' => $data['ttl'] ?? null,
                        'alamat_asal' => $data['alamat_asal'] ?? null,
                    ]);
                } else {
                    Biodata::create([
                        'user_id' => $user->id,
                        'jenis_kelamin' => $data['gender'],
                        'nama_kampus' => $data['kampus'],
                        'prodi' => $data['program_studi'],
                        'status' => $data['status_aktivitas'] ?? null,
                    ]);
                }
            });

            return response()->json([
                'message' => 'Data lecturer berhasil diperbarui'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            Log::error('Gagal update lecturer: ' . $e->getMessage());
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
        $user = User::where('sub_role', 'lecturer')->findOrFail($id);
        $user->delete(); // lecturer ikut terhapus (cascade)

        return response()->json([
            'message' => 'Data lecturer berhasil dihapus'
        ]);
    }
}
