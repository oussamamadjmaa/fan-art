<x-modal.form :title="isset($product) ? __('Edit Product') : __('Add Product')">
    @if (isset($product))
        @method('PUT')
        <input type="hidden" name="model_id" value="{{ $product->id }}">
    @endif

    <x-form.input name="name" inputAttributes="required" label="Product name" :value="$product->name ?? ''" />

    <x-form.input type="file" name="image" id="image" label="Product image"
        inputAttributes="onchange=_s.uploadImage(this) data-path=products" :value="$product?->image ?? ''" />

    <x-form.select2 name="category_id" label="Category" required="required">
        <option value="">@lang('Select Category')...</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected($category->id == old('category_id', $product?->category_id))>{{ $category->name }}</option>
        @endforeach
    </x-form.select2>

    <x-form.input name="price" inputAttributes="required" label="Price ({{config('app.currency')}})" :value="(price_format($product?->price ?? 0))" />

    <x-form.input type="textarea" name="description" label="Description" :value="$product->description ?? ''" inputAttributes="required" />
</x-modal.form>
