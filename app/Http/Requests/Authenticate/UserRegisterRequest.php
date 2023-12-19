<?php

namespace App\Http\Requests\Authenticate;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'nik' => 'required|string|unique:users',
            'name' => 'required|string',
            'email' => 'required|email:dns|unique:users',
            'phone' => 'required|string|min:11|max:18',
        ];
    }
}
