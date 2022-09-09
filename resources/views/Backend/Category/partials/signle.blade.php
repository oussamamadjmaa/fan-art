<div class="category_-item d-flex border-bottom py-2 justify-content-between align-items-center {{$class ?? ''}} px-3" id="category_{{$category->id}}">
    <div class="d-flex align-items-center">
        <div class="checkbox me-3">
            <div class="form-check">
                <input class="form-check-input checkbox___item" name="news[]" type="checkbox" value="{{$category->id}}">
            </div>
        </div>
        <div class="category-info d-flex flex-wrap">
            <div>
                <div class="category-title fs-6 mb-1">
                    <h6>{{$category->name}}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="category-actions d-flex flex-wrap align-items-center justify-content-center" style="gap: 10px;">
        <div class="dropdown open">
            <a type="button" class="button py-1" id="categoryActionsDropDown{{ $category->id }}" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                        <i class="bi bi-three-dots"></i>
                    </a>
            <div class="dropdown-menu" aria-labelledby="categoryActionsDropDown{{ $category->id }}">
                <button type="button" class="dropdown-item text-primary" href="javascript:;" onclick="_s.openCreateForm(this, {{$category->id}})"><i class="bi bi-pencil-square"></i> @lang('Edit')</button>
                <button type="button" class="dropdown-item text-danger" href="javascript:;" onclick="_s.onDelete(this, {{$category->id}})"><i class="bi bi-trash"></i> @lang('Delete')</button>
            </div>
        </div>
    </div>
</div>
