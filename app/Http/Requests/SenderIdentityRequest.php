<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SenderIdentityRequest extends FormRequest
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
        $method = $this->getMethod(); // 'PATCH' or 'POST'
        $emailRules = ['required', 'email'];

        if ($method == 'POST') {
            $emailRules[] = 'unique:sender_identities';
        }

        return [
            'name' => 'required',
            'email' => implode('|', $emailRules),
            'is_default' => 'nullable',
        ];
    }
}
