<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileDataFilterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tckr_symb' => 'nullable|string|max:255',
            'rpt_dt' => 'nullable|date',
        ];
    }

    public function attributes()
    {
        return [
            'tckr_symb' => 'TckrSymb',
            'rpt_dt' => 'RptDt'
        ];
    }

    public function messages()
    {
        return [
            'tckr_symb.string' => 'O :attribute deve ser um texto válido.',
            'tckr_symb.max' => 'O :attribute não pode ter mais que 255 caracteres.',
            'rpt_dt.date' => 'A :attribute deve estar em um formato válido.',
        ];
    }
}
