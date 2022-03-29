<?php

namespace App\Http\Requests\Auth\Register;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class ResendPhoneCodeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['phone' => "string"])] public function rules(): array
    {
        return [
            'phone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'phone')->where('status', User::STATUS_ACTIVE),
            ],
        ];
    }
}
