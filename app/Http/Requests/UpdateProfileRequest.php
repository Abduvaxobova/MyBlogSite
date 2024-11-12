<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
            'name' => 'nullable|string',
            'username' => [
                'nullable',
                Rule::unique('users')->ignore(Auth::id()),
            ],
            'email' => [
                'nullable',
                'email',

                Rule::unique('users')->ignore(Auth::id()),
            ],
            'old_password' => 'nullable',
            'new_password' => 'nullable',
            'avatar' => 'nullable|mimes:png,jpg|max:2048',
        ];
    }
}
