<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventInternalUpdateRequest extends FormRequest
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
            'kategori' => 'required|integer',
            'event_title' => 'required',
            'tipe_peserta' => 'required|integer',
            'tgl_buka' => 'required',
            'tgl_tutup' => 'required',
            'role' => 'required',
            'maks' => 'required',
            'oldBanner' => 'required',
            'oldPoster' => 'required',
        ];
    }
}
