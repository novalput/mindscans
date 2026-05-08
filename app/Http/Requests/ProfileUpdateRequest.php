<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            // Student fields
            'kampus' => ['nullable', 'string', 'max:255'],
            'program_studi' => ['nullable', 'string', 'max:255'],
            'student_gender' => ['nullable', 'string', 'in:male,female'],
            'status' => ['nullable', 'string', 'max:255'],
            // Lecturer fields
            'kampus_lecturer' => ['nullable', 'string', 'max:255'],
            'program_studi_lecturer' => ['nullable', 'string', 'max:255'],
            'lecturer_gender' => ['nullable', 'string', 'in:male,female'],
            'status_aktivitas' => ['nullable', 'string', 'max:255'],
            // Others fields
            'kampus_others' => ['nullable', 'string', 'max:255'],
            'job_description' => ['nullable', 'string', 'max:255'],
            'others_gender' => ['nullable', 'string', 'in:male,female'],
        ];
    }
}
