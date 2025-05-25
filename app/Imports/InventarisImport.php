<?php

namespace App\Imports;

use App\Models\Inventaris;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Log;

class InventarisImport implements ToModel, WithValidation
{
    use Importable;

    public function model(array $row)
    {
        // Log isi kolom asal_barang agar bisa cek di laravel.log
        Log::info('Asal Barang dibaca:', ['asal_barang' => $row[1]]);

        return new Inventaris([
            'id'                 => (string) Str::uuid(),
            'jenis_barang'       => trim($row[0]),
            'asal_barang'        => strtolower(trim($row[1])), // sanitize: trim + lowercase
            'keadaan_barang'     => strtolower(trim($row[2])),
            'penghapusan_barang' => strtolower(trim($row[3])),
            'keterangan'         => trim($row[4]),
        ]);
    }

    public function rules(): array
    {
        return [
            '*.0' => 'required|string|max:255',
            '*.1' => ['required', Rule::in([
                'dibeli sendiri',
                'bantuan pemerintah',
                'bantuan provinsi',
                'bantuan kabupaten',
                'sumbangan',
            ])],
            '*.2' => ['required', Rule::in(['baik','rusak'])],
            '*.3' => ['required', Rule::in(['dipakai','rusak','dijual','disumbangkan'])],
            '*.4' => 'required|string|max:255',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.1.in' => 'Asal Barang tidak valid.',
            '*.1.required' => 'Kolom Asal Barang wajib diisi.',
            '*.2.in' => 'Keadaan Barang tidak valid.',
            '*.3.in' => 'Penghapusan Barang tidak valid.',
            '*.4.required' => 'Kolom Keterangan wajib diisi.',
        ];
    }
}
