<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLecturerRequest;
use App\Http\Requests\UpdateLecturerRequest;
use App\Models\User;
use App\Models\Lecturer;
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
    public function index()
    {
        $lecturer = User::with('lecturer')
            ->where('role', 'lecturer')
            ->latest()
            ->paginate(10);

        return view('admin.lecturer.index', compact('lecturer'));
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

            'nip' => 'required|unique:lecturer,nip',
            'education' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
        ]);

        DB::transaction(function () use ($data) {

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'] ?? null,
                'phone' => $data['phone'] ?? null,
                'password' => Hash::make($data['password']),
                'role' => 'lecturer',
            ]);

            Lecturer::create([
                'user_id' => $user->id,
                'nip' => $data['nip'],
                'education' => $data['education'] ?? null,
                'specialization' => $data['specialization'] ?? null,
                'bio' => $data['bio'] ?? null,
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
        $user = User::with('lecturer')->findOrFail($id);

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
                'nip' => [
                    'required',
                    Rule::unique('lecturer', 'nip')->ignore($user->lecturer->id)
                ],
                'education' => 'nullable|string|max:255',
                'specialization' => 'nullable|string|max:255',
                'bio' => 'nullable|string',
            ]);

            DB::transaction(function () use ($user, $data) {
                $user->update([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                ]);

                $user->lecturer->update([
                    'nip' => $data['nip'],
                    'education' => $data['education'],
                    'specialization' => $data['specialization'],
                    'bio' => $data['bio'],
                ]);
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
        $user = User::where('role', 'lecturer')->findOrFail($id);
        $user->delete(); // lecturer ikut terhapus (cascade)

        return response()->json([
            'message' => 'Data lecturer berhasil dihapus'
        ]);
    }
}
