<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Hanya update name dan email pada model User
        $user->fill($request->safe()->only(['name', 'email']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Update data spesifik berdasarkan role
        if ($user->role === 'student' && $user->student) {
            $user->student->update([
                'nim' => $request->nim,
                'jenjang' => $request->jenjang,
                'kampus' => $request->kampus,
                'program_studi' => $request->program_studi,
                'gender' => $request->student_gender,
                'status' => $request->status,
            ]);
        } elseif ($user->role === 'lecturer' && $user->lecturer) {
            $user->lecturer->update([
                'kampus' => $request->kampus_lecturer,
                'program_studi' => $request->program_studi_lecturer,
                'gender' => $request->lecturer_gender,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'jabatan_fungsional' => $request->jabatan_fungsional,
                'status_ikatan_kerja' => $request->status_ikatan_kerja,
                'status_aktivitas' => $request->status_aktivitas,
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
