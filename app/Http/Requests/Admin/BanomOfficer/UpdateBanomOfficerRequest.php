<?php

namespace App\Http\Requests\Admin\BanomOfficer;

use App\Models\Banom;
use App\Models\BanomOfficer;
use App\Models\Position;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateBanomOfficerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'position_id' => ['required', 'exists:positions,id'],
            'division_id' => ['nullable', 'exists:divisions,id'],
            'member_id' => ['nullable', 'exists:members,id'],
            'nama' => ['nullable', 'string', 'max:255', 'required_without:member_id'],
            'bidang' => ['nullable', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'urutan_wakil' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'position_id.required' => 'Jabatan wajib dipilih.',
            'position_id.exists' => 'Jabatan yang dipilih tidak valid.',
            'division_id.exists' => 'Bagian / Bidang yang dipilih tidak valid.',
            'member_id.exists' => 'Anggota yang dipilih tidak valid.',
            'nama.required_without' => 'Nama pengurus wajib diisi jika tidak memilih anggota.',
            'foto.image' => 'File foto harus berupa gambar.',
            'foto.mimes' => 'Format foto harus jpg, jpeg, png, atau webp.',
            'foto.max' => 'Maksimal 10 MB, sistem akan mengecilkan otomatis.',
            'urutan.integer' => 'Urutan harus berupa angka bulat.',
            'urutan_wakil.integer' => 'Urutan wakil harus berupa angka positif.',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $banomParam = $this->route('banom') ?? $this->input('banom_id');
            $banom = null;

            if ($banomParam instanceof Banom) {
                $banom = $banomParam;
            } elseif (is_numeric($banomParam)) {
                $banom = Banom::find($banomParam);
            } elseif (is_string($banomParam) && !empty($banomParam)) {
                $banom = Banom::where('slug', $banomParam)->orWhere('singkatan', $banomParam)->orWhere('id', $banomParam)->first();
            }

            $officerParam = $this->route('officer');
            $officer = $officerParam instanceof BanomOfficer ? $officerParam : BanomOfficer::find($officerParam);

            if (!$banom || !$officer) {
                return;
            }

            $position = Position::find($this->position_id);
            if (!$position) {
                return;
            }

            $isActive = $this->boolean('is_active', true);

            // 1. Validasi Batas Keras (Hanya jabatan yang memang satu orang atau batas_keras = true)
            if ($isActive && ($position->batas_keras || (!is_null($position->maks_orang) && $position->maks_orang === 1))) {
                $query = BanomOfficer::where('banom_id', $banom->id)
                    ->where('position_id', $position->id)
                    ->where('is_active', true)
                    ->where('id', '!=', $officer->id);

                if ($position->nama === 'Ketua Bidang' || $position->kategori === 'Bidang') {
                    if (!empty($this->division_id)) {
                        $query->where('division_id', $this->division_id);
                    } elseif (!empty($this->bidang)) {
                        $query->where('bidang', $this->bidang);
                    }
                }

                $currentCount = $query->count();
                $limit = $position->maks_orang ?? 1;

                if ($currentCount >= $limit) {
                    $validator->errors()->add(
                        'position_id',
                        "Jabatan ini sudah terisi, ubah atau nonaktifkan pengurus lama terlebih dahulu."
                    );
                }
            }

            // 2. Anjuran Lunak (Soft warning)
            if ($isActive && !$position->batas_keras && $position->hasAnjuran()) {
                $currentCount = BanomOfficer::where('banom_id', $banom->id)
                    ->where('position_id', $position->id)
                    ->where('is_active', true)
                    ->where('id', '!=', $officer->id)
                    ->count();

                $newTotal = $currentCount + 1;
                if ($newTotal > $position->anjuran_maks) {
                    $this->merge([
                        '_soft_warning' => "Perhatian: Jumlah {$position->nama} ({$newTotal} orang) melebihi anjuran ({$position->anjuran_maks} orang). Data tetap berhasil disimpan."
                    ]);
                }
            }

            // 3. Mencegah duplikasi anggota pada jabatan dan banom yang sama
            if (!empty($this->member_id)) {
                $exists = BanomOfficer::where('banom_id', $banom->id)
                    ->where('position_id', $position->id)
                    ->where('member_id', $this->member_id)
                    ->where('id', '!=', $officer->id)
                    ->exists();

                if ($exists) {
                    $banomName = $banom->singkatan ?: $banom->nama;
                    $validator->errors()->add('member_id', "Anggota ini sudah terdaftar pada jabatan {$position->nama} di {$banomName}.");
                }
            }
        });
    }
}
