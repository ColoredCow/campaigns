<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SenderIdentityRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $subscriber = $this->route('subscriber');

        return [
            'email' => [
                'required',
                'email',
                Rule::unique('sender_identities')->ignore($subscriber->id ?? null),
            ],
            'name' => 'required|string',
            'is_default' => 'nullable|boolean',
        ];
    }
}
