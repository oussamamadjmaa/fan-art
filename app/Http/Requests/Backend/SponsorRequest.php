<?php

namespace App\Http\Requests\Backend;

use App\Rules\ValidateFileRule;
use Illuminate\Foundation\Http\FormRequest;

class SponsorRequest extends FormRequest
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

    public function prepareForValidation()
    {
        return $this->merge([
            'phone' => str_replace(['(', ')', '+', ' ', '-', '_'], '', $this->phone),
            //  'skype' => Str::replace(['/', '\\', '-', '|',"#", ",", ';'], '', ($this->skype ?? NULL))
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
            'name'      => ['required', 'string', 'max:191'],
            'logo'      => ['required', new ValidateFileRule('sponsors', ['png', 'jpeg', 'jpg', 'webp'])],
            'website'   => ['required', 'url', 'max:191'],
            'country'   => ['required', 'string', 'in:' . implode(',', array_keys(countries())), 'max:2'],
            'phone'     => ['nullable', 'regex:/[0-9]/', 'not_regex:/[A-z]/', 'between:8,30',],
            'email'     => ['nullable', 'string', 'email', 'max:191'],
            'address'   => ['nullable', 'string', 'max:191'],
        ];
    }
}
