@extends('Backend.Layout.master', ['title' => __('Exhibitions')])
@section('content')
@can('create', App\Models\Exhibition::class)
<div>
    <x-buttons.icon-button :text="__('Add Exhibition')" onclick="_s.openCreateForm(this)" />
</div>
@endcan
<x-card.page-data-template title="Exhibitions" :actions="auth()->user()->hasRole('artist')" count_text="Exhibition" icon="bi bi-calendar-heart" />

@endsection
