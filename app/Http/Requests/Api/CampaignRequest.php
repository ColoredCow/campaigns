<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CampaignRequest extends FormRequest
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
            'subscription_list_id' => 'required|integer|exists:lists,id',
            'sender_identity_id' => 'required|integer|exists:sender_identities,id',
            'email_subject' => 'required|string',
            'email_body' => 'required|string',
            'attachments' => 'nullable|array',
        ];
    }
}
