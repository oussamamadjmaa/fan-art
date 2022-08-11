<x-modal.form :title="isset($artwork) ? __('Edit Artwork') : __('Add Artwork')">
    @if (isset($artwork))
        @method("PUT")
        <input type="hidden" name="model_id" value="{{ $artwork->id }}">
    @endif

    <x-form.input name="title" inputAttributes="required" label="Painting title" :value="($artwork->title ?? '')" />

    <x-form.input name="price" inputAttributes="required" label="Price ({{config('app.currency')}})" :value="(price_format($artwork?->price ?? 0))" />

    <x-form.input type="file" name="image" id="image" label="Painting Image"  inputAttributes="onchange=_s.uploadImage(this) data-path=artworks" :value="($artwork?->image ?? '')" />

    <div class="mb-3">
      <label for="materials_used" class="form-label">@lang('Materials used')</label>
      <textarea class="form-control @error('materials_used') is-invalid @enderror" name="materials_used" id="materials_used" rows="3" placeholder="@lang('Materials used')">{{ ($artwork?->materials_used ?? '') }}</textarea>
      <div class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
      <label for="tools" class="form-label">@lang('Tools')</label>
      <textarea class="form-control @error('tools') is-invalid @enderror" name="tools" id="tools" rows="3" placeholder="@lang('Tools')">{{ ($artwork?->tools ?? '') }}</textarea>
      <div class="invalid-feedback"></div>
    </div>
    <div>
        <div class="form-check form-switch mb-3 col-12">
            <input class="form-check-input me-4" type="checkbox" name="outer_frame" id="outer_frame" value="1" @checked($artwork->outer_frame ?? false) style="transform:scale(1.5) translateX(-5px);">
            <label class="form-check-label" for="outer_frame">@lang('Outer frame')</label>
        </div>
    </div>
    <x-form.input name="dimensions" inputAttributes="required" label="Painting dimensions (CM)" :value="($artwork->dimensions ?? '')" />

    <div>
        <div class="form-check form-switch mb-3 col-12">
            <input class="form-check-input me-4" type="checkbox" name="covered_with_glass" id="covered_with_glass" value="1" @checked($artwork->covered_with_glass ?? false) style="transform:scale(1.5) translateX(-5px);">
            <label class="form-check-label" for="covered_with_glass">@lang('Covered with glass')</label>
        </div>
    </div>

    <x-form.input name="location" inputAttributes="required" label="Painting location (Country, City, Address)" :value="($artwork->location ?? '')" />

    <x-form.select2 name="status" label="Painting status" inputAttributes="required">
        <option value="1" @selected($artwork?->status === App\Models\Artwork::READY)>@lang('Ready for delivery')</option>
        <option value="0" @selected($artwork?->status === App\Models\Artwork::NOT_READY)>@lang('In preparation')</option>
        <option value="2" @selected($artwork?->status === App\Models\Artwork::SOLD)>@lang('Sold')</option>
    </x-form.select2>

    <div class="mb-3">
        <label for="description" class="form-label">@lang('Painting description')</label>
        <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3" placeholder="@lang('Painting description')" required>{{ ($artwork?->description ?? '') }}</textarea>
        <div class="invalid-feedback"></div>
    </div>
</x-modal.form>
