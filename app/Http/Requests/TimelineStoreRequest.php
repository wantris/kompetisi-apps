<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimelineStoreRequest extends FormRequest
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
            'tgl_jadwal' => 'required',
            'deskripsi' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'event_id.integer' => 'Pilih Event!',
            'title.required' => 'Judul Timeline Required!',
            'tgl_jadwal.required' => 'Jadwal Timeline Required!',
            'deskripsi.required' => 'Deskripsi Timeline Required!',
        ];
    }
}
