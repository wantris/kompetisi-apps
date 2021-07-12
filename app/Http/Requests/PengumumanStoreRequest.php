<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengumumanStoreRequest extends FormRequest
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
            'event_id' => 'required|integer',
            'title' => 'required',
            'deskripsi' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'event_id.integer' => 'Pilih Event!',
            'title.required' => 'Judul Pengumuman Required!',
            'deskripsi.required' => 'Deskripsi Pengumuman Required!',
        ];
    }
}
