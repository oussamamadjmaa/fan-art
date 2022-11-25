<?php

namespace App\Http\Requests\Backend;

use App\Models\Artwork;
use App\Rules\ValidateFileRule;
use Illuminate\Foundation\Http\FormRequest;

class ArtworkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if($this->isMethod('POST')) return auth()->user()->can('create', Artwork::class);
        else return auth()->user()->can('update', $this->route('artwork'));
    }

    public function prepareForValidation(){
        return $this->merge([
            'price' => (int) (((float) $this->price) * 100),
            'covered_with_glass' => $this->outer_frame ? 1 : 0,
            'covered_with_glass' => $this->covered_with_glass ? 1 : 0,

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
            'title'                     => ['required', 'string', 'max:255'],
            'price'                     => ['required', 'integer'],
            'image'                     => ['required', new ValidateFileRule('artworks', ['png', 'jpeg', 'jpg', 'webp'])],
           // 'materials_used'            => ['nullable', 'string', 'max:400'],
           // 'tools'                     => ['nullable', 'string', 'max:400'],
            'type'                      => ['required', 'string', 'max:255'],
            'outer_frame'               => ['boolean'],
            'dimensions'                => ['required', 'string', 'max:255'],
          //  'covered_with_glass'        => ['boolean'],
            'location'                  => ['required', 'string', 'max:300'],
            'status'                    => ['required', 'in:1,2'],
          //  'description'               => ['required', 'string', 'max:700'],
            'url'                       => ['nullable', 'url', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'url.url' => 'صيغة رابط الشراء غير صحيحة',
            'url.max' => 'الرابط طويل  جدا, الرجاء اختصاره',
        ];
    }
}
