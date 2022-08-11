@extends('Backend.Layout.master', ['title' => __('News')])
@section('content')
<div>
    <x-buttons.icon-button :text="__('Add News')" onclick="_s.openCreateForm(this)" />
</div>

<x-card.page-data-template title="News" count_text="News" icon="bi bi-newspaper" />

@endsection
