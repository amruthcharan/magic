<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
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
            'is_active' => 'required|boolean',
            'sdk_url' => 'required_if:is_active,1|nullable|url',
            'is_identity_enabled' => 'required|boolean',
            'is_idl_aync' => 'required|boolean',
            'is_idl_optimised' => 'required|boolean',
            'identity_url' => 'required_if:is_identity_enabled,1|nullable|url',
            'cookie_key' => 'string',
            'cache_time' => 'integer',
            'id_type' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'is_active.required' => 'Please select at least one option.',
            'sdk_url.required_if' => 'The sdk_url field is required to enable.',
            'sdk_url.url' => 'The sdk_url seems to be incorrect.',
            'is_identity_enabled.required' => 'Please select at least one option..',
            'is_idl_aync.required' => 'Please select at least one option.',
            'is_idl_optimised.required' => 'Please select at least one option.',
            'identity_url.required_if' => 'The identity_url field is required to enable IDL.',
            'identity_url.url' => 'The identity_url seems to be incorrect.',
            'id_type.required' => 'Please select at least one option.',
        ];
    }
}
