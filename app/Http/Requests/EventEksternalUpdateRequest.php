<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventEksternalUpdateRequest extends FormRequest
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
            'kategori' => 'required',
            'tipe_peserta' => 'required',
            'maks' => 'required|integer',
            'role' => 'required',
            'tgl_buka' => 'required',
            'tgl_tutup' => 'required',
            'deskripsi' => 'required',
            'oldPoster' => 'required',
            'oldBanner' => 'required'
        ];
    }
}
