<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ArtworkMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() ? ($this->route('artwork')->user_id != auth()->id()) : true;
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'phone' => str_replace(['(', ')', '+', ' ', '-', '_'], '', $this->phone),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if (auth()->check()) {
            return [
                'message' => ['required', 'string', 'between:3,500'],
            ];
        }

        return [
            'message' => ['required', 'string', 'between:3,500'],
            'first_name' => ['required', 'string', 'between:3,60'],
            'last_name' => ['required', 'string', 'between:3,60'],
            'email' => ['required', 'string', 'email', 'max:191'],
            'phone'     => ['required', 'regex:/[0-9]/', 'not_regex:/[A-z]/', 'between:8,20',],
        ];
    }
}
