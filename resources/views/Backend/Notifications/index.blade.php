@extends('Backend.Layout.master')
@section('content')
<x-card.page-data-template title="Notifications" count_text="Notifications" icon="bi bi-bell">

</x-card.page-data-template>
@endsection
@push('styles')
<style>
    .pagination{
        padding: 1rem 0;
        justify-content: center;
    }
</style>
@endpush
