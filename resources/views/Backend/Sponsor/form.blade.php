<x-modal.form :title="isset($sponsor) ? __('Edit Sponsor') : __('Add Sponsor')">
    @if (isset($sponsor))
        @method('PUT')
        <input type="hidden" name="model_id" value="{{ $sponsor->id }}">
    @endif

    <x-form.input name="name" inputAttributes="required" label="Sponsor name" :value="$sponsor->name ?? ''" />

    <x-form.input type="file" name="logo" id="logo" label="Logo"
        inputAttributes="onchange=_s.uploadImage(this) data-path=sponsors" :value="$sponsor?->logo ?? ''" />

    <x-form.input name="website" inputAttributes="required" label="Website url" :value="$sponsor->website ?? ''" />

    <x-form.select2 name="country" label="Country" required="required">
        <option value="">@lang('Select Country')...</option>
        @foreach ($countries as $countryCode => $country)
            <option value="{{ $countryCode }}" @selected($countryCode == old('country', $sponsor?->country ?: strtolower(auth()->user()->country)))>@lang(country($countryCode)->getName())</option>
        @endforeach
    </x-form.select2>

    <x-form.input name="phone" label="Phone" :value="$sponsor->phone ?? ''" />
    <x-form.input type="email" name="email" label="Email" :value="$sponsor->email ?? ''" />
    <x-form.input name="address" label="Address" :value="$sponsor->address ?? ''" />
</x-modal.form>
