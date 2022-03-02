<?php

namespace App\Http\Requests\Auth\Register;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class ResendEmailCodeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['email' => "string"])] public function rules(): array
    {
        return [
            'email' => 'required|string|max:255|email:filter|unique:users,email',
        ];
    }
}
