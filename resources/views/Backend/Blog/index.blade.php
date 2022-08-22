@extends('Backend.Layout.master', ['title' => __('Blog')])
@section('content')
@can('create', 'App\\Models\News')
<div>
    <x-buttons.icon-button :text="__('Add Blog')" onclick="_s.openCreateForm(this)" />
</div>
@endcan
<x-card.page-data-template title="Blog" count_text="Blog" icon="fa fa-blog" />

@endsection
