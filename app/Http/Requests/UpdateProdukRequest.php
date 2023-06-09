<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProdukRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'kategori_id' => ['required'],
            'sub_kategori_id' => ['required'],
            // 'jurusan_id' => ['required'],
            'nama' => ['required'],
            // 'kode' => ['required'],
            'merek' => ['required'],
            'kondisi' => ['required'],
            'ket_produk' => ['required'],
            'ket_kondisi' => ['required'],
            'fotos.*' => 'file|max:5025|image'
        ];
    }
}
