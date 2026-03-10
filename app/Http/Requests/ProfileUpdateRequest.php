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
            'nim' => ['nullable', 'string', 'max:255'],
            'jenjang' => ['nullable', 'string', 'max:255'],
            'kampus' => ['nullable', 'string', 'max:255'],
            'program_studi' => ['nullable', 'string', 'max:255'],
            'student_gender' => ['nullable', 'string', 'in:male,female'],
            'status' => ['nullable', 'string', 'max:255'],
            // Lecturer fields
            'kampus_lecturer' => ['nullable', 'string', 'max:255'],
            'program_studi_lecturer' => ['nullable', 'string', 'max:255'],
            'lecturer_gender' => ['nullable', 'string', 'in:male,female'],
            'pendidikan_terakhir' => ['nullable', 'string', 'max:255'],
            'jabatan_fungsional' => ['nullable', 'string', 'max:255'],
            'status_ikatan_kerja' => ['nullable', 'string', 'max:255'],
            'status_aktivitas' => ['nullable', 'string', 'max:255'],
        ];
    }
}
