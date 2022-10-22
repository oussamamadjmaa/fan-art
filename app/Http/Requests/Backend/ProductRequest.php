<?php

namespace App\Http\Requests\Backend;

use App\Models\Product;
use App\Rules\ValidateFileRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if($this->isMethod('POST')) return auth()->user()->can('create', Product::class);
        else return auth()->user()->can('update', $this->route('product'));
    }

    public function prepareForValidation(){
        return $this->merge([
            'price' => (int) (((float) $this->price) * 100),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        $category_rule = auth()->user()->hasRole('admin') ? ['nullable', 'exists:categories,id'] : ['nullable', 'exists:categories,id,user_id,'.auth()->id()];
        return [
            'name'                     => ['required', 'string', 'max:191'],
            'image'                     => ['required', new ValidateFileRule('products', ['png', 'jpeg', 'jpg', 'webp'])],
            'category_id'        => $category_rule,
            'price'                     => ['required', 'integer'],
            'description'               => ['required', 'string', 'max:700'],
        ];
    }
}
