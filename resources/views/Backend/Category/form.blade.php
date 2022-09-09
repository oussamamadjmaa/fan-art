<x-modal.form :title="isset($category) ? __('Edit Category') : __('Add Category')">
    @if (isset($category))
        @method('PUT')
        <input type="hidden" name="model_id" value="{{ $category->id }}">
    @endif

    <x-form.input name="name" inputAttributes="required" label="Category name" :value="$category->name ?? ''" />
</x-modal.form>
