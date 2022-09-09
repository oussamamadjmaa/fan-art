@extends('Backend.Layout.master', ['title' => __('Categories')])
@section('content')
@can('create', App\Models\Category::class)
<div>
    <x-buttons.icon-button :text="__('Add Category')" onclick="_s.openCreateForm(this)" />
</div>
@endcan
<x-card.page-data-template title="Categories" :actions="auth()->user()->hasRole('store')" count_text="Category" icon="fa fa-list" />

@endsection
