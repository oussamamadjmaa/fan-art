@extends('Backend.Layout.master', ['title' => __('Carousels')])
@section('content')
<div>
    <x-buttons.icon-button :text="__('Add Carousel')" onclick="_s.openCreateForm(this)" />
</div>

<x-card.page-data-template title="Carousels" count_text="Carousel" icon="bi bi-file-earmark-richtext" />
<hr>
<div class="card p-0">
    <div class="card-body p-0">
        <div class="p-3 border-bottom bg-light">
            <h4 class="mb-0">@lang('Carousel order manager')</h4>
        </div>
        <h5 class="text-center mt-3">@lang('Drag and change carousel order')</h6>
        <form method="POST" class="col-md-6 mx-auto p-3" action="javascript:;" id="reorder_form">
            @csrf
            @method('PUT')
            <ul class="row col-12 mx-auto" style="list-style: none" id="sortable">
                @foreach ($carousels as $i => $carousel)
                    <li class="text-center col-12 border py-3 mb-2 carousel_item_o">
                        <input type="hidden" name="carousel[{{$carousel->id}}]" value="{{$i}}">
                        <h5 class="mb-0">{{$carousel->name}}</h5>
                    </li>
                @endforeach
            </ul>

            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-primary" id="save-order">@lang('Save')</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script type="module">
    $("#sortable").sortable();

    $("#save-order").on('click', function(){
        $(".carousel_item_o").each(function(i){
            $(this).find('input').val(i);
        })

        $.post("{{route('backend.carousel.reorder')}}", $("#reorder_form").serialize(), function(res){
            toastr.success(res.message)
        });
    });
</script>
@endpush
