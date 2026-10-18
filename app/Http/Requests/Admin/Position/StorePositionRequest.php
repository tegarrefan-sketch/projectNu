<?php

namespace App\Http\Requests\Admin\Position;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePositionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('positions', 'nama')->where('kategori', $this->kategori),
            ],
            'kategori' => ['required', 'string', 'max:50'],
            'tipe' => ['required', 'in:inti,wakil,anggota'],
            'maks_orang' => ['nullable', 'integer', 'min:1'],
            'batas_keras' => ['nullable', 'boolean'],
            'anjuran_maks' => ['nullable', 'integer', 'min:1'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'urutan_hierarki' => ['nullable', 'integer', 'min:0'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama jabatan wajib diisi.',
            'nama.unique' => 'Jabatan dengan nama ini sudah ada pada kategori yang sama.',
            'kategori.required' => 'Kategori jabatan wajib dipilih.',
            'kategori.in' => 'Kategori jabatan tidak valid.',
            'maks_orang.integer' => 'Batas maksimal orang harus berupa angka bulat.',
            'maks_orang.min' => 'Batas maksimal orang minimal 1.',
            'urutan.integer' => 'Urutan harus berupa angka bulat.',
        ];
    }
}
