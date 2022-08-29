<?php

namespace App\Http\Requests\Backend;

use Hash;
use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if($this->route('tab') == "artist_profile" && auth()->user()->hasRole('artist')) {
            return true;
        }
        return in_array($this->route('tab'), ['profile', 'password']);
    }

    public function prepareForValidation()
    {
        if ($this->route('tab') == "profile") {
            return $this->merge([
                'phone' => str_replace(['(', ')', '+', ' ', '-', '_'], '', $this->phone),
                //  'skype' => Str::replace(['/', '\\', '-', '|',"#", ",", ';'], '', ($this->skype ?? NULL))
            ]);
        }
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $tab = $this->route('tab');
        if ($tab == "profile") {
            //  $email_rule = app()->isLocal() ? 'email:filter' : 'email:rfc,dns';
            $rules = [
                'username'      => ['required', 'string', 'alpha_dash', 'between:3,60', 'unique:users,username,' . auth()->id() . ',id'],
                'name'          => ['required', 'string', 'max:191'],
                'phone'         => ['nullable', 'regex:/[0-9]/', 'not_regex:/[A-z]/', 'between:8,30',],
                'gender'        => ['required', 'in:male,female'],
                'nationality'   => ['required', 'string', 'in:' . implode(',', array_keys(__('nationalities')))],
                'country'       => ['required', 'string', 'in:' . implode(',', array_keys(countries())), 'max:2'],
                //    'email'         => ['required', 'string', $email_rule, 'max:191', 'unique:users'],
                'current_password'      => ['required', 'string', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        return $fail(__('Current password is not correct'));
                    }
                }],
            ];

            //Address is required for stores
            if(auth()->user()->hasRole('store'))
                $rules['address'] = ['required', 'string', 'max:350'];

            return $rules;
        }else if($tab == "password"){
            return [
                'current_password' => ['required', function ($attribute, $value, $fail)  {
                    if (!Hash::check($value, auth()->user()->password)) {
                        return $fail('كلمة المرور الحالية غير صحيحة');
                    }
                }],
                'new_password' => ['required','confirmed','min:8', function ($attribute, $value, $fail)  {
                    if (Hash::check($value, auth()->user()->password)) {
                        return $fail(__('The new password must be different from the current one'));
                    }
                }],
            ];
        }else if($tab == "artist_profile"){
            return [
                'bio'       => ['required', 'string', 'between:3,700'],
                'cv'        => ['nullable', 'file', 'mimetypes:application/pdf', 'max:3072'],
                'facebook'  => ['nullable', 'url'],
                'instagram' => ['nullable', 'url'],
                'twitter'   => ['nullable', 'url'],
                'linkedin'  => ['nullable', 'url']
            ];
        }
    }
}