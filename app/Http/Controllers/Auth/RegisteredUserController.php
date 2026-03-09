<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginAttempt;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'string', 'max:15', 'unique:' . User::class],
            'role' => ['required', 'in:student,lecturer'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];

        // Conditional Validation Rules based on role
        if ($request->role === 'student') {
            $rules = array_merge($rules, [
                'nim' => ['required', 'string', 'max:255', 'unique:students,nim'],
                'kampus' => ['required', 'string', 'max:255'],
                'jenjang' => ['required', 'string', 'max:255'],
                'program_studi' => ['required', 'string', 'max:255'],
                'gender' => ['required', 'in:male,female'],
                'status' => ['required', 'string', 'max:255'],
            ]);
        } else if ($request->role === 'lecturer') {
            $rules = array_merge($rules, [
                'gender_lecturer' => ['required', 'in:male,female'], // Using gender_lecturer to separate from student gender in view
                'kampus_lecturer' => ['required', 'string', 'max:255'],
                'program_studi_lecturer' => ['required', 'string', 'max:255'],
                'jabatan_fungsional' => ['required', 'string', 'max:255'],
                'pendidikan_terakhir' => ['required', 'string', 'max:255'],
                'status_ikatan_kerja' => ['required', 'string', 'max:255'],
                'status_aktivitas' => ['required', 'string', 'max:255'],
            ]);
        }

        $request->validate($rules);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        if ($request->role === 'student') {
            \App\Models\Student::create([
                'user_id' => $user->id,
                'nim' => $request->nim,
                'kampus' => $request->kampus,
                'jenjang' => $request->jenjang,
                'program_studi' => $request->program_studi,
                'gender' => $request->gender,
                'status' => $request->status,
            ]);
        } else if ($request->role === 'lecturer') {
            \App\Models\Lecturer::create([
                'user_id' => $user->id,
                'gender' => $request->gender_lecturer,
                'kampus' => $request->kampus_lecturer,
                'program_studi' => $request->program_studi_lecturer,
                'jabatan_fungsional' => $request->jabatan_fungsional,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'status_ikatan_kerja' => $request->status_ikatan_kerja,
                'status_aktivitas' => $request->status_aktivitas,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        // Update last login
        $user->update(['last_login_at' => now()]);

        // Log login attempt
        LoginAttempt::create([
            'destination' => $user->email,
            'channel' => 'password',
            'ip_address' => $request->ip(),
            'success' => true,
        ]);

        return redirect()->route('dashboard');
    }
}
