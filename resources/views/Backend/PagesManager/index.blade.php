@extends('Backend.Layout.master', ['title' => __('Pages Manager')])
@section('content')
<div>
    <x-buttons.icon-button :text="__('Add Page')" onclick="_s.openCreateForm(this)" />
</div>

<x-card.page-data-template title="Pages" count_text="Page" icon="bi bi-file-earmark-richtext" />

@endsection
