<x-modal.form :title="isset($exhibition) ? __('Edit Exhibition') : __('Add Exhibition')">
    @if (isset($exhibition))
        @method('PUT')
        <input type="hidden" name="model_id" value="{{ $exhibition->id }}">
    @endif

    <x-form.input name="name" inputAttributes="required" label="Exhibition name" :value="$exhibition->name ?? ''" />

    <div class="row">
        <div class="col-md-6"><x-form.input type="date" name="from_date" label="From date" :value="($exhibition?->from_date?->format('Y-m-d') ?? '')" inputAttributes="required autocomplete=off" /></div>
        <div class="col-md-6"><x-form.input type="date" name="to_date" label="To date" :value="($exhibition?->to_date?->format('Y-m-d') ?? '')" inputAttributes="required autocomplete=off" /></div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <x-form.select2 name="sponsor_id" label="Sponsor" inputAttributes="required">
                <option value="">@lang('Select Sponsor')...</option>
                <option value="">@lang('Without sponsor')</option>
                @foreach ($sponsors as $sponsor)
                    <option value="{{ $sponsor->id }}" @selected($sponsor->id == old('sponsor_id', $exhibition?->sponsor_id))>{{ $sponsor->name }}</option>
                @endforeach
            </x-form.select2>
        </div>
        <div class="col-md-6">
            <x-form.select2 name="country" label="Country" inputAttributes="required">
                <option value="">@lang('Select Country')...</option>
                @foreach ($countries as $countryCode => $country)
                    <option value="{{ $countryCode }}" @selected($countryCode == old('country', $exhibition?->country ?: strtolower(auth()->user()->country)))>@lang(country($countryCode)->getName())</option>
                @endforeach
            </x-form.select2>
        </div>
    </div>

    <x-form.input name="city" label="City" inputAttributes="required" :value="$exhibition->city ?? ''" />

    <x-form.input name="registration_url" inputAttributes="required" label="Registration url" :value="$exhibition->registration_url ?? ''" />
</x-modal.form>
