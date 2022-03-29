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
    #[ArrayShape(['correspondent_account' => "string", 'bik' => "string", 'snils' => "string", 'address' => "string", 'birth_date' => "string"])] public function rules(): array
    {
        return [
            'correspondent_account' => 'required',
            'bik' => 'required',
            'snils' => 'required',
            'address' => 'required',
            'birth_date' => 'required'
        ];
    }
}
