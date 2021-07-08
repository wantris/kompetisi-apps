<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PembinaStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
         return [
            'nama_dosen' => 'required',
            'tahun_jabatan' => 'required|integer',
            'status' => 'required|boolean'
        ];
    }

    public function messages()
    {
        return [
            'tahun_jabatan.integer' => 'Pilih Tahun Jabatan!',
            'status.boolean' => 'Pilih status!'
        ];
    }
}
