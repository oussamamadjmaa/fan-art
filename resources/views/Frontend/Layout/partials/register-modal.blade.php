<div class="modal fade" id="registerationLinks" tabindex="-1" role="dialog" aria-labelledby="registerationLinksTtitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <div class="row register-links">
                    <a class="col-md-4 register_role" href="javascript:;{{-- {{ route('register', 'customer') }} --}}">
                        <h1><i class="fas fa-user"></i></h1>
                        <h5>@lang('Customer')</h5>
                    </a>
                    <a class="col-md-4 register_role" href="{{ route('register', 'artist') }}">
                        <h1><i class="fas fa-palette"></i></h1>
                        <h5>@lang('Artist')</h5>
                    </a>
                    <a class="col-md-4 register_role" href="{{ route('register', 'store') }}">
                        <h1><i class="fas fa-store"></i></h1>
                        <h5>@lang('Store')</h5>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
