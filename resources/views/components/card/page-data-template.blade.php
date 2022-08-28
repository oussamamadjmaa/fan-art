@props([
    'title' => '',
    'count_text' => '',
    'icon' =>'',
    'actions' => false,
    'checkbox' => true,
])
<div class="card mt-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
        <div class="d-flex mb-3 mb-md-0">
            @if ($checkbox == true)
            <div class="checkbox me-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" onchange="_s.checkAllItems(this)">
                </div>
            </div>
            @endif
            <div class="d-flex flex-wrap">
                <h5 class="mb-0"><i class="{{$icon}}"></i> @lang($title)</h5> <span class="text-secondary ms-2">
                    {{-- (<span class="items-count">0</span> @lang($count_text))</span> --}}
            </div>
        </div>
        @if ($actions || auth()->user()->hasRole('admin'))
        <div class="actions flex-grow">
            <div class="dropdown">
                <button class="button" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"><i class="bi bi-magic"></i> @lang('Actions')</button>
                <div class="dropdown-menu" aria-labelledby="triggerId">
                    <a class="dropdown-item text-danger" href="javascript:;" onclick="_s.multipleDelete();"><i class="bi bi-trash"></i> @lang('Delete')</a>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="card-body p-0">
        <div id="page-data-list">
            {{$slot}}
        </div>
    </div>
</div>
