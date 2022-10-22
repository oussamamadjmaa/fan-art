@extends('Backend.Layout.master', ['title' => __('Products')])
@section('content')
@can('create', App\Models\Product::class)
<div>
    <x-buttons.icon-button :text="__('Add Product')" onclick="_s.openCreateForm(this)" />
</div>
@endcan
<x-card.page-data-template title="Products" :actions="auth()->user()->hasRole('store')" count_text="Product" icon="fa fa-store" />

@endsection
