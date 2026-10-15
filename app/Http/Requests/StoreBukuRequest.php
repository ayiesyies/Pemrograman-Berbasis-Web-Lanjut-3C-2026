<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\StoreBukuRequest;

class StoreBukuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

  public function rules(): array
    {
        return [
            'kategori_id'  => 'required|exists:kategoris,id',
            'judul'        => 'required|string|min:3|max:255',
            'penulis'      => 'required|string|max:255',
            'penerbit'     => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|between:1900,2026',
        ];
    }

    public function messages(): array
    {
        return [
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'kategori_id.exists'   => 'Kategori yang dipilih tidak tersedia.',
            'judul.required'       => 'Judul buku wajib diisi.',
            'judul.string'         => 'Judul buku harus berupa teks.',
            'judul.min'            => 'Judul buku minimal 3 karakter.',
            'judul.max'            => 'Judul buku maksimal 255 karakter.',
            'penulis.required'     => 'Nama penulis wajib diisi.',
            'penulis.string'       => 'Nama penulis harus berupa teks.',
            'penerbit.required'    => 'Penerbit wajib diisi.',
            'penerbit.string'      => 'Penerbit harus berupa teks.',
            'tahun_terbit.required'=> 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer' => 'Tahun terbit harus berupa bilangan bulat.',
            'tahun_terbit.between' => 'Tahun terbit harus antara 1900 sampai 2026.',
        ];
    }

    public function attributes(): array
    {
        return [
            'kategori_id'  => 'kategori',
            'judul'        => 'judul buku',
            'penulis'      => 'penulis',
            'penerbit'     => 'penerbit',
            'tahun_terbit' => 'tahun terbit',
        ];
    }
}