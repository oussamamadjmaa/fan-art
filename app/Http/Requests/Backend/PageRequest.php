<?php

namespace App\Http\Requests\Backend;

use App\Rules\ValidateFileRule;
use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
            'slug' => slugme($this->slug),
            'content' => strip_tags($this->input('content') ?? '', [...config('app.allowed_html_tags'), 'a']),
            'status' => $this->status ? 1 : 0,
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
            'title'             => 'required|string|max:191',
            'slug'              => 'required|string|max:191|unique:pages,slug,'.($this->route('page')->id ?? false),
            'content'           => 'required|string',
            'seo'               => 'required|array',
            'seo.title'         => 'nullable|string|max:100',
            'seo.description'   => 'nullable|string|max:191',
            'seo.image'         => ['nullable', new ValidateFileRule('pages', ['png', 'jpeg', 'jpg', 'webp'])],
            'status'            => 'boolean'
        ];
    }
}
