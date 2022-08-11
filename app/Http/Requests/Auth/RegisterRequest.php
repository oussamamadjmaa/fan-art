<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        $role = $this->route('role');
        $email_rule = app()->isLocal() ? 'email:filter' : 'email:rfc,dns';
        $rules = [
            //Artist registration rules
            'artist' => [
                'username'          => ['required', 'string', 'alpha_dash', 'max:191', 'unique:users'],
                'name'          => ['required', 'string', 'max:191'],
                'nationality'   => ['required', 'string', 'in:'.implode(',', array_keys(__('nationalities')))],
                'country'       => ['required', 'string', 'in:'.implode(',', array_keys(countries())), 'max:2'],
                'gender'        => ['required', 'in:male,female'],
                'website'       => ['nullable', 'url'],
                'phone'         => ['nullable', 'regex:/[0-9]/', 'not_regex:/[A-z]/', 'between:8,30',],
                'email'         => ['required', 'string', $email_rule, 'max:191', 'unique:users'],
                'password'      => ['required', 'string', 'min:8', 'confirmed'],

            ]
        ];
        return $rules[$role];
    }
}
