<x-modal.form :title="isset($carousel) ? __('Edit Carousel') : __('Add Carousel')">
    @if (isset($carousel))
        @method("PUT")
        <input type="hidden" name="model_id" value="{{ $carousel->id }}">
    @endif

    <x-form.input name="name" inputAttributes="required" :value="($carousel->name ?? '')" />

    <x-form.input type="file" name="background_image" id="background_image" label="Background Image"  inputAttributes="onchange=_s.uploadImage(this) data-path=carousels" :value="($carousel?->background_image ?? '')" />

    <div>
        <div class="form-check form-switch mb-3 col-12">
            <input class="form-check-input me-4" type="checkbox" name="cover" id="cover" value="1" @checked($carousel->cover ?? true) style="transform:scale(1.5) translateX(-5px);">
            <label class="form-check-label" for="cover">@lang('Cover')</label>
        </div>
    </div>

    <x-form.input name="text" label="Carousel text" inputAttributes="required" :value="($carousel->text ?? '')" />
    <x-form.input name="secondary_text" :value="($carousel->secondary_text ?? '')" />

    <x-form.select2 name="action" label="Action Type" inputAttributes="required">
        <option value="button_link" @selected($carousel?->action == "button_link")>@lang('Button Link')</option>
        <option value="countdown" @selected($carousel?->action == "countdown")>@lang('Countdown')</option>
        <option value="nothing" @selected($carousel?->action == "nothing")>@lang('No thing')</option>
    </x-form.select2>

    <div class="action_inputs_">
        <div id="button_link_inputs" class="p-3 bg-light rounded" {{ (($carousel->action ?? 'button_link') != "button_link") ? "style=display:none;" : '' }}>
            <x-form.input name="action_data[text]" label="Button text" :value="($carousel?->action_data['text'] ?? '')" />
            <x-form.input name="action_data[url]" label="Button url" :value="($carousel?->action_data['url'] ?? '')" />
            <x-form.input type="color" name="action_data[color]" label="Button color" :value="($carousel?->action_data['color'] ?? '#f26822')" />
        </div>

        <div id="countdown_inputs" class="p-3 bg-light rounded" {{ (($carousel?->action) != "countdown") ? "style=display:none;" : '' }}>
            <x-form.input type="date" name="action_data[countdown_date]" label="Countdown Date" :value="($carousel?->action_data['countdown_date'] ?? '')" />
        </div>
    </div>

    <hr>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="1" id="status" name="status" @checked($carousel?->status ?? true)>
      <label class="form-check-label" for="status">
        @lang('Activate')
      </label>
    </div>

    <script>
        $(document).on('change', '#action', function(){
            $('.action_inputs_>*').hide();
            $("#"+$(this).val()+"_inputs").show();
        });
    </script>
</x-modal.form>
