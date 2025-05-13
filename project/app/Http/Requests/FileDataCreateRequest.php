<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileDataCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'file' => 'required|mimes:csv,txt,xls,xlsx',
        ];
    }

    public function attributes()
    {
        return [
            'file' => 'arquivo'
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'O :attribute é obrigatório.',
            'file.mimes' => 'O :attribute deve ser um arquivo do tipo: csv'
        ];
    }
}
