<?php
namespace App\Http\Requests\System;
use Illuminate\Foundation\Http\FormRequest;
class StoreUserRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->can('users.create') ?? false; }
    public function rules(): array {
        return [
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:8','confirmed'],
            'password_confirmation' => ['required','string','min:8'],
            'role' => ['required','string','exists:roles,name'],
            'is_active' => ['nullable','boolean'],
        ];
    }
    public function messages(): array {
        return [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'role.required' => 'Role wajib dipilih.',
            'role.exists' => 'Role tidak valid.',
        ];
    }
}
