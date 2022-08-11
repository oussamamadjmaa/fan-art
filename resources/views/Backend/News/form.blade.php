<x-modal.form :title="isset($singleNews) ? __('Edit News') : __('Add News')">
    @if (isset($singleNews))
        @method('PUT')
        <input type="hidden" name="model_id" value="{{ $singleNews->id }}">
    @endif

    <x-form.input name="title" inputAttributes="required" :value="$singleNews->title ?? ''" />

    <x-form.input type="file" name="image" id="image" label="News Image"
        inputAttributes="onchange=_s.uploadImage(this) data-path=news" :value="$singleNews?->image ?? ''" />

    <x-form.input name="image_description" :value="$singleNews->image_description ?? ''" />
    <div class="mb-3">
        <label for="body" class="form-label">@lang('News Body')</label>
        <textarea class="form-control newsBodyTextarea" name="body" id="body" rows="6" required>{{ $singleNews->body ?? '' }}</textarea>
        <div class="invalid-feedback"></div>
    </div>

    <h5 class="mt-4">@lang('SEO Data')</h5>
    <hr>

    <div class="seo-inputs">
        <x-form.input name="seo[title]" id="seo__title" label="SEO Title" :value="$singleNews?->seo['title'] ?? ''" />
         <div class="mb-3">
            <label for="seo__description" class="form-label">@lang('SEO Description')</label>
            <textarea class="form-control" name="seo[description]" id="seo__description" rows="3">{{ $singleNews?->seo['description'] ?? '' }}</textarea>
            <div class="invalid-feedback"></div>
        </div>
        <x-form.input name="seo[keywords]" id="seo__keywords" label="SEO Keywords" :value="$singleNews?->seo['keywords'] ?? ''" />
    </div>
    <hr>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="1" id="status" name="status"
            @checked($singleNews?->status ?? true)>
        <label class="form-check-label" for="status">
            @lang('Publish')
        </label>
    </div>
    <div>
        <div>
            <div>
                <script>
                    _s.makeTinymce(".newsBodyTextarea");
                </script>
            </div>
        </div>
    </div>


</x-modal.form>
