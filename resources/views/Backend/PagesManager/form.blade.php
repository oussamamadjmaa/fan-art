<x-modal.form :title="isset($page) ? __('Edit Page') : __('Add Page')">
    @if (isset($page))
        @method("PUT")
        <input type="hidden" name="model_id" value="{{ $page->id }}">
    @endif

    <x-form.input name="title" inputAttributes="required" :value="($page->title ?? '')" />
    <x-form.input name="slug" inputAttributes="required" placeholder="" help="e.g: privacy-policy, about, my-page, سياسة-الخصوصية" :value="($page->slug ?? '')" />
    <div class="mb-3">
      <label for="content" class="form-label">@lang('Page Content')</label>
      <textarea class="form-control pageContentTextarea" name="content" id="content" rows="6" required>{{ ($page->content ?? '') }}</textarea>
      <div class="invalid-feedback"></div>
    </div>

    <h5 class="mt-4">@lang('SEO Data')</h5>
    <hr>

    <div class="seo-inputs">
        <x-form.input name="seo[title]" id="seo__title" label="SEO Title" :value="($page?->seo['title'] ?? '')" />
        <div class="mb-3">
          <label for="seo__description" class="form-label">@lang('SEO Description')</label>
          <textarea class="form-control" name="seo[description]" id="seo__description" rows="3">{{ ($page?->seo['description'] ?? '') }}</textarea>
          <div class="invalid-feedback"></div>
        </div>
        <x-form.input type="file" name="seo[image]" id="seo__image" label="SEO Image"  inputAttributes="onchange=_s.uploadImage(this) data-path=pages" :value="($page?->seo['image'] ?? '')" />
    </div>
    <hr>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="1" id="status" name="status" @checked($page?->status ?? true)>
      <label class="form-check-label" for="status">
        @lang('Show in footer')
      </label>
    </div>
    <div>
        <div>
            <div>
                <script>
                    _s.makeTinymce(".pageContentTextarea")
                </script>
            </div>
        </div>
    </div>
</x-modal.form>
