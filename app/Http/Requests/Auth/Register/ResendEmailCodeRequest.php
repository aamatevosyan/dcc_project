<?php

namespace App\Http\Requests\Auth\Register;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
            'email' => [
                'required',
                'string',
                'max:255',
                'email:filter',
                Rule::unique('users', 'email')->where('status', User::STATUS_ACTIVE)
            ],
        ];
    }
}
