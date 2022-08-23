<?php

namespace App\Http\Requests\Backend;

use App\Rules\ValidateFileRule;
use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
        $this->merge([
            'status' => $this->status ? 1 : 0,
            'seo' => [
                'title' => $this->seo['title'] ?? '',
                'description' => $this->seo['description'] ?? '',
                'keywords'  => $this->seo['keywords'] ?? '',
                'body' => cleanHtml($this->input('body') ?? ''),
                'image' => $this->input('image')
            ]
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
            'title' => ['required', 'string', 'max:191'],
            'image' => ['required', new ValidateFileRule('news', ['png', 'jpg', 'jpeg', 'webp'])],
            'image_description' => ['nullable', 'string', 'max:191'],
            'body' => ['required', 'string'],
            'seo' => ['array'],
            'seo.title' => ['nullable', 'string', 'max:191'],
            'seo.keywords' => ['nullable', 'string'],
            'seo.description' => ['nullable', 'string'],
            'status' => 'boolean'
        ];
    }
}
