@extends('Backend.Layout.master', ['title' => __('Support tickets')])
@section('content')
@unlessrole('admin')
<div>
    <x-buttons.icon-button :text="__('Open a support ticket')" onclick="_s.openCreateForm(this)" />
</div>
@endunlessrole

<div class="card mt-3">
    <div class="card-body pb-0">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>@lang('Ticket number')</th>
                        <th>@lang('Subject')</th>
                        <th>@lang('Last person to intervene')</th>
                        <th>@lang('Creation date')</th>
                        <th>@lang('Last update')</th>
                        <th>@lang('Status')</th>
                    </tr>
                </thead>
                <tbody id="page-data-list">
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
