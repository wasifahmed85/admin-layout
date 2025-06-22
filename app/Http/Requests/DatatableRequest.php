<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DatatableRequest extends FormRequest
{
       
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'datas.*.id' => 'required|integer',
            'datas.*.newOrder' => 'required|integer',
            'model' => 'required|string',
        ];
    }
}
