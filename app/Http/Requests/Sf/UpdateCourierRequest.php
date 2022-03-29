<?php

namespace App\Http\Requests\Sf;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class UpdateCourierRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['inn' => "string", 'citizenship' => "string", 'passport_code' => "string", 'passport_num' => "string", 'correspondent_account' => "string", 'bik' => "string", 'snils' => "string", 'address' => "string", 'birth_date' => "string"])]
    public function rules(): array
    {
        return [
            'inn' => 'required|digits_between:10,12',
            'citizenship' => 'required',
            'passport_code' => 'required|numeric|gt:0',
            'passport_num' => 'required|numeric|gt:0',
            'correspondent_account' => 'required',
            'bik' => 'required',
            'snils' => 'required',
            'address' => 'required',
            'birth_date' => 'required'
        ];
    }
}
