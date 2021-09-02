<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventEksternalStoreRequest extends FormRequest
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
            'event_title' => 'required',
            'category' => 'required',
            'jenis_peserta' => 'required',
            'peserta' => 'required',
            'jenis' => 'required',
            'tgl_mulai' => 'required',
            'tgl_tutup' => 'required',
            'deskripsi' => 'required',
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'banner' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
