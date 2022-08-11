<?php

namespace App\Http\Requests\Backend;

use App\Rules\ValidateFileRule;
use Illuminate\Foundation\Http\FormRequest;

class CarouselRequest extends FormRequest
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
            'status' => $this->status ? 1 : 0,
            'cover' => $this->cover ? 1 : 0,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'name'                         => 'required|string|max:191',
            'background_image'             => ['required', new ValidateFileRule('carousels', ['png', 'jpeg', 'jpg', 'webp'])],
            'cover'                        => 'boolean',
            'text'                         => 'required|string|max:191',
            'secondary_text'               => 'nullable|string|max:191',
            'action'                       => 'required|in:button_link,countdown,nothing',
            'action_data'                  => 'required|array',
            'status'                       => 'boolean'
        ];
        if($this->input('action') == "button_link"){
            $rules['action_data.text']  = 'required_if:action,button_link|string|max:40';
            $rules['action_data.url']   = 'required_if:action,button_link|url';
            $rules['action_data.color'] = 'required_if:action,button_link|string|max:15';
        }else if($this->input('action') == "countdown"){
            $rules['action_data.countdown_date'] = 'required_if:action,countdown|date_format:Y-m-d';
        }
        return $rules;
    }
}
