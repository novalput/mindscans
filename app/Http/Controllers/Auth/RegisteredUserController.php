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
            'role' => ['required', 'in:student,lecturer'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];

        $request->validate($rules);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => 'responden',
            'sub_role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        \App\Models\Biodata::create([
            'user_id' => $user->id,
            'jenis_kelamin' => $request->gender,
        ]);

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
