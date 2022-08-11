@extends('Backend.Layout.master', ['title' => __('Paintings and artworks')])
@section('content')
<div>
    <x-buttons.icon-button :text="__('Add Artwork')" onclick="_s.openCreateForm(this)" />
</div>

<x-card.page-data-template title="Artworks" :actions="auth()->user()->hasRole('artist')" count_text="Artwork" icon="bi bi-file-earmark-richtext" />

@endsection
