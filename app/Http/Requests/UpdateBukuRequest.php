<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\UpdateBukuRequest;

class UpdateBukuRequest extends StoreBukuRequest 

{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kategori_id'  => 'sometimes|required|exists:kategoris,id',
            'judul'        => 'sometimes|required|string|min:3|max:255',
            'penulis'      => 'sometimes|required|string|max:255',
            'tahun_terbit' => 'sometimes|required|integer|between:1900,2026',
        ];
    }

    public function messages(): array
    {
        return (new StoreBukuRequest())->messages();
    }

    public function attributes(): array
    {
        return (new StoreBukuRequest())->attributes();
    }
}