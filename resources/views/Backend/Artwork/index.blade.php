@extends('Backend.Layout.master', ['title' => __('Paintings and artworks')])
@section('content')
@can('create', App\Models\Artwork::class)
<div>
    <x-buttons.icon-button :text="__('Add Artwork')" onclick="_s.openCreateForm(this)" />
</div>
@endcan
<x-card.page-data-template title="Artworks" :actions="auth()->user()->hasRole('artist')" count_text="Artwork" icon="bi bi-palette" />

@endsection
