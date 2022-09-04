<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'              => ['required', 'string', 'max:191'],
            'from_date'         => ['required', 'date_format:Y-m-d'],
            'to_date'           => ['required', 'date_format:Y-m-d', 'after_or_equal:from_date'],
            'sponsor_id'        => ['nullable', 'exists:sponsors,id,user_id,'.auth()->id()],
            'country'           => ['required', 'string', 'in:' . implode(',', array_keys(countries())), 'max:2'],
            'city'              => ['required', 'string', 'max:191'],
            'registration_url'  => ['required', 'url', 'max:191'],
        ];
    }
}
