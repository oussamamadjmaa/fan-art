@props([
    'text' => 'Button',
    'icon' => 'fa fa-plus'
])
<button {{ $attributes->class('icon-button') }} {{$attributes}}>
    <i class="{{$icon}} @if($text) me-1 @endif"></i>
    <span>{{$text}}</span>
</button>
