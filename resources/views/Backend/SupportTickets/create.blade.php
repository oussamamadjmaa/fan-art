<x-modal.form :title="__('Open a support ticket')" submit_btn_text="Open a support ticket">
    <x-form.input name="subject" inputAttributes="required" label="Ticket subject"/>
    <div class="mb-3">
        <label for="message" class="form-label">@lang('Message')</label>
        <textarea class="form-control @error('message') is-invalid @enderror" name="message" id="message" rows="5" placeholder="@lang('Message')" required></textarea>
        <div class="invalid-feedback"></div>
    </div>
</x-modal.form>
