<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Aturan validasi untuk update profil.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'   => ['required', 'string', 'max:255'],
            'email'  => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // Maksimal 2MB
        ];
    }

    /**
     * Pesan error dalam Bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'name.required'  => 'Nama lengkap wajib diisi.',
            'name.max'       => 'Nama tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Alamat email ini sudah terdaftar oleh pengguna lain.',
            'avatar.image'   => 'Berkas foto profil harus berupa gambar.',
            'avatar.mimes'   => 'Format foto profil harus berformat JPG, JPEG, PNG, atau WEBP.',
            'avatar.max'     => 'Ukuran foto profil maksimal 2MB.',
        ];
    }
}
