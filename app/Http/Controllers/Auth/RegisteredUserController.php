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
            'gender' => ['required', 'in:male,female'],
            'role' => ['required', 'in:student,lecturer,others'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];

        // Conditional Validation Rules based on role
        if ($request->role === 'student') {
            $rules = array_merge($rules, [
                'kampus' => ['required', 'string', 'max:255'],
                'program_studi' => ['required', 'string', 'max:255'],
                'status' => ['required', 'string', 'max:255'],
            ]);
        } else if ($request->role === 'lecturer') {
            $rules = array_merge($rules, [
                'kampus_lecturer' => ['required', 'string', 'max:255'],
                'program_studi_lecturer' => ['required', 'string', 'max:255'],
                'status_aktivitas' => ['required', 'string', 'max:255'],
            ]);
        } else if ($request->role === 'others') {
            $rules = array_merge($rules, [
                'kampus_others' => ['required', 'string', 'max:255'],
                'job_description' => ['required', 'string', 'max:255'],
            ]);
        }

        $request->validate($rules);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => 'responden',
            'sub_role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        if ($request->role === 'student') {
            \App\Models\Biodata::create([
                'user_id' => $user->id,
                'jenis_kelamin' => $request->gender,
                'nama_kampus' => $request->kampus,
                'prodi' => $request->program_studi,
                'status' => $request->status,
            ]);
        } else if ($request->role === 'lecturer') {
            \App\Models\Biodata::create([
                'user_id' => $user->id,
                'jenis_kelamin' => $request->gender,
                'nama_kampus' => $request->kampus_lecturer,
                'prodi' => $request->program_studi_lecturer,
                'status' => $request->status_aktivitas,
            ]);
        } else if ($request->role === 'others') {
            \App\Models\Biodata::create([
                'user_id' => $user->id,
                'jenis_kelamin' => $request->gender,
                'nama_kampus' => $request->kampus_others,
                'job_description' => $request->job_description,
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
