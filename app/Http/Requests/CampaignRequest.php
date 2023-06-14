<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampaignRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sender_identity_id' => 'required|integer|exists:sender_identities,id',
            'subscription_list_id' => 'required|integer',
            'email_subject' => 'required|string',
            'email_body' => 'required|string',
            'attachments' => 'nullable|array',
        ];
    }
}
