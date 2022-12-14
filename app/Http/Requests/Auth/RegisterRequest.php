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
        $phone_plus = (substr(($this->phone ?? ''), 0, 1) == "+") ? "+" : '';
        return $this->merge([
            'phone' => $phone_plus.str_replace(['(', ')', '+', ' ', '-', '_'], '', $this->phone),
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
                'artist_type'   => ['required', 'in:'.implode(',', config('app.artist_types', []))],
                'username'      => ['required', 'string', 'alpha_dash', 'between:3,60', 'unique:users'],
                'name'          => ['required', 'string', 'max:191'],
                'nationality'   => ['required', 'string', 'in:'.implode(',', array_keys(__('nationalities')))],
                'country'       => ['required', 'string', 'in:'.implode(',', array_keys(countries())), 'max:2'],
                'website'       => ['nullable', 'url'],
                'phone'         => ['nullable', 'regex:/[0-9]/', 'not_regex:/[A-z]/', 'between:8,30',],
                'email'         => ['required', 'string', $email_rule, 'max:191', 'unique:users'],
                'password'      => ['required', 'string', 'min:8', 'confirmed'],
            ],
            'store' => [
                'username'      => ['required', 'string', 'alpha_dash', 'between:3,60', 'unique:users'],
                'name'          => ['required', 'string', 'max:191'],
                'country'       => ['required', 'string', 'in:'.implode(',', array_keys(countries())), 'max:2'],
                'address'       => ['required', 'string', 'max:350'],
                'website'       => ['nullable', 'url'],
                'phone'         => ['nullable', 'regex:/[0-9]/', 'not_regex:/[A-z]/', 'between:8,30',],
                'email'         => ['required', 'string', $email_rule, 'max:191', 'unique:users'],
                'password'      => ['required', 'string', 'min:8', 'confirmed'],
            ],
            'customer' => [
                'name'          => ['required', 'string', 'max:191'],
                'country'       => ['required', 'string', 'in:'.implode(',', array_keys(countries())), 'max:2'],
                'username'      => ['required', 'string', 'alpha_dash', 'between:3,60', 'unique:users'],
                'email'         => ['required', 'string', $email_rule, 'max:191', 'unique:users'],
                'address'       => ['required', 'string', 'max:350'],
                'gender'        => ['required', 'in:male,female'],
                'phone'         => ['nullable', 'regex:/[0-9]/', 'not_regex:/[A-z]/', 'between:8,30',],
                'password'      => ['required', 'string', 'min:8', 'confirmed'],
            ]
        ];
        return $rules[$role];
    }
}
