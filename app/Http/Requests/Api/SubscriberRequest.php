<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $subscriber = $this->route('subscriber');

        return [
            'email' => [
                $subscriber ? 'nullable' : 'required',
                'email',
                Rule::unique('subscribers')->ignore($subscriber->id ?? null),
            ],
            'name' => [
                $subscriber ? 'nullable' : 'required',
                'string',
            ],
            'phone' => 'nullable|string',
            'tags' => 'nullable|array',
            'is_subscribed' => 'nullable|boolean',
        ];
    }
}
