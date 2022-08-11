<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ArtistPorfileSetupRequest extends FormRequest
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

    public function prepareForValidation(){
        return $this->merge([
            'avatar' => auth()->user()->avatar
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'avatar'    => ['required', 'string'],
            'bio'       => ['required', 'string', 'max:700'],
            'cv'        => ['nullable', 'file', 'mimetypes:application/pdf', 'max:3072'],
            'facebook'  => ['nullable', 'url'],
            'instagram' => ['nullable', 'url'],
            'twitter'   => ['nullable', 'url'],
            'linkedin'  => ['nullable', 'url']
        ];
    }
}
