<?php

namespace App\Http\Requests\Admin\Banom;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBanomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $banomId = $this->route('banom') instanceof \App\Models\Banom 
            ? $this->route('banom')->id 
            : $this->route('banom');

        return [
            'nama' => ['required', 'string', 'max:255'],
            'singkatan' => ['required', 'string', 'max:30', Rule::unique('banoms', 'singkatan')->ignore($banomId)],
            'kategori' => ['nullable', 'string', 'in:ranting,banom'],
            'rentang_usia' => ['nullable', 'string', 'max:100'],
            'label_bagian' => ['nullable', 'string', 'max:50'],
            'deskripsi' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama Badan Otonom wajib diisi.',
            'singkatan.required' => 'Singkatan Badan Otonom wajib diisi.',
            'singkatan.unique' => 'Singkatan Badan Otonom sudah terdaftar.',
            'logo.image' => 'File logo harus berupa gambar.',
            'logo.mimes' => 'Format logo harus jpeg, png, jpg, atau webp.',
            'logo.max' => 'Ukuran logo maksimal 2MB.',
            'urutan.integer' => 'Urutan harus berupa angka bulat.',
        ];
    }
}
