@extends('Backend.Layout.master', ['title' => __('Sponsors')])
@section('content')
@can('create', App\Models\Sponsor::class)
<div>
    <x-buttons.icon-button :text="__('Add Sponsor')" onclick="_s.openCreateForm(this)" />
</div>
@endcan
<x-card.page-data-template title="Sponsors" :actions="auth()->user()->hasRole('artist')" count_text="Sponsor" icon="far fa-handshake" />

@endsection
