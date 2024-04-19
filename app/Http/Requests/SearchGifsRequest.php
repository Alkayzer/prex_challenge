<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchGifsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'query' => 'required|string|max:255',
            'limit' => 'sometimes|integer|min:1|max:100',
            'offset' => 'sometimes|integer|min:0'
        ];
    }
}
