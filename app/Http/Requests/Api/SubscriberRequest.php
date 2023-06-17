<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class SubscriberRequest extends FormRequest
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
        return [
            // 'email' => 'required|email|unique:subscribers',
            'email' => 'required|email',
            'name' => 'required|string',
            'phone' => 'nullable|string',
            'subscription_lists' => 'nullable|array',
        ];
    }
}