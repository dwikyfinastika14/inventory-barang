<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBarangRequset extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_barang' => 'sometimes|required|string|max:255',
            'jumlah_stok' => 'sometimes|required|integer|min:0',
            'nomor_seri' => 'nullable|string|max:255',
            'additional_info' => 'nullable|json',
            'gambar_barang' => 'nullable|image|mimes:jpeg,png|max:2048',
        ];
    }
}
