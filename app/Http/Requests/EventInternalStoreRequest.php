<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventInternalStoreRequest extends FormRequest
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
            'category' => 'required|integer',
            'event_title' => 'required',
            'peserta' => 'required|integer',
            'tgl_mulai' => 'required',
            'tgl_tutup' => 'required',
            'jenis' => 'required',
            'jenis_peserta' => 'required|integer',
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'banner' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'category.integer' => 'Pilih Kategori Event Internal!',
        ];
    }
}
