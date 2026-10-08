<?php
namespace App\Http\Requests\System;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->can('users.update') ?? false; }
    public function rules(): array {
        $userId = $this->route('user')?->id ?? $this->route('user');
        return [
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255', Rule::unique('users','email')->ignore($userId)],
            'password' => ['nullable','string','min:8','confirmed'],
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
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'role.required' => 'Role wajib dipilih.',
            'role.exists' => 'Role tidak valid.',
        ];
    }
}
