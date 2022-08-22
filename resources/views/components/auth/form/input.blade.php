@props(['type'])
@php
$icons = [
    'name'                  => 'fa fa-user',
    'password'              => 'fa fa-lock',
    'password_confirmation' => 'fa fa-lock',
    'email'                 => 'fa fa-envelope',
    'nationality'           => 'fa fa-globe',
    'country'               => 'bi bi-geo-alt-fill',
    'gender'                => 'fa fa-venus-mars',
    'website'               => 'fas fa-external-link-alt',
    'phone'                 => 'fa fa-phone',
    'username'              => 'fa fa-user',
    'facebook'              => 'fab fa-facebook',
    'instagram'              => 'fab fa-instagram',
    'twitter'              => 'fab fa-twitter',
    'linkedin'              => 'fab fa-linkedin',
];
$icon = $icons[$attributes->get('name')] ?? 'fas fa-question-circle';
@endphp

@if($type == "textarea")
<div class="mb-3">
    <div class="input-container">
        <label for="{{ $attributes->get('id') }}" class="form-label"><i class="{{ $icon }}"></i></label>
        <textarea
            {{ $attributes->class(['form-control'])->merge([
            ]) }} >{{ $attributes->get('value') }}</textarea>
    </div>
    @error($attributes->get('name'))
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
@elseif ($type == 'email')
    <div class="mb-3">
        <div class="input-container">
            <label for="{{ $attributes->get('id') }}" class="form-label"><i class="{{ $icon }}"></i></label>
            <input
                {{ $attributes->class(['form-control'])->merge([
                    'type' => 'email',
                    'name' => 'email',
                    'id' => 'email',
                    'autocomplete' => 'email',
                ]) }} />
        </div>
        @error($attributes->get('name'))
            <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
@elseif($type == 'select')
    <div class="mb-3">
        <div class="input-container">
            <label for="{{ $attributes->get('id') }}" class="form-label"><i class="{{$icon}}"></i></label>
            <select
                {{ $attributes->class(['form-control'])->merge([
                    'type' => $type,
                ]) }}>
                {{ $slot }}
            </select>
        </div>
        @error($attributes->get('name'))
            <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
@else
    <div class="mb-3">
        <div class="input-container">
            <label for="{{ $attributes->get('id') }}" class="form-label"><i class="{{ $icon }}"></i></label>
            <input
                {{ $attributes->class(['form-control'])->merge([
                    'type' => $type,
                ]) }}>
            @if ($type == 'password')
                <span class="show-password"><i class="fa"></i></span>
            @endif
        </div>

        @error($attributes->get('name'))
            <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
@endif
