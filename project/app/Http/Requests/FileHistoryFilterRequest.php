<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileHistoryFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'created_at' => 'nullable|date',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nome',
            'created_at' => 'Data de referência',
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'O :attribute deve ser um texto válido.',
            'name.max' => 'O :attribute não pode ter mais que 255 caracteres.',
            'created_at.date' => 'A :attribute deve estar em um formato válido.',
        ];
    }}
