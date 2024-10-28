@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-md-6 card-header border-0 px-4 py-3 bg-transparent">
        <h5 class="mb-3">{{$pageTitle}}</h5>
    </div>
</div>
@if(isset($role))
    <form action="{{ route('admin.roles.save', @$role->id) }}" method="post" class="row g-3 needs-validation" novalidate >
    @method('POST')
@else
   <form action="{{ route('admin.roles.save') }}" method="post" class="row g-3 needs-validation" novalidate >
@endif
    @csrf
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card pb-2">
                <div class="card-body p-4">
                    <div class="form-group">
                        <label for="bsValidation9" class="form-label">Name</label>
                        <input class="form-control" name="name" id="bsValidation9" type="text"  value="{{ old('name', @$role->name) }}">
                    </div>

                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Set Permissions</h5>
                </div>
                <div class="card-body">
                    <div class="">
                        <div class="row gy-4">
                            @foreach ($permissionGroups as $key => $permissionGroup)
                                <div class="col-12">
                                    <div class="permission-item">
                                        <div class="row gy-2 justify-content-center align-items-center">
                                            <div class="col-sm-3">
                                                <span>{{ Str::replaceLast('Controller', '', $key) }}</span>
                                              
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="d-flex flex-wrap gap-3">
                                                    @foreach ($permissionGroup as $permission)
                                                        <div class="custom-control custom-checkbox form-check-primary">
                                                            <input class="custom-control-input" id="customCheck{{ $permission->id }}" name="permissions[]" type="checkbox" value="{{ $permission->id}}" @if(isset($role) && in_array($permission->id, $role->permissions->pluck('id')->toArray())) checked @endif>

                                                            <label class="custom-control-label" for="customCheck{{ $permission->id }}">{{ $permission->name }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <button class="btn btn-primary h-45 w-100" type="submit">@lang('Submit')</button>
        </div>
    </div>
</form>
      
</div>
@endsection
@push('style-lib')
    <style>
    .permission-item{
        background: #fafafa;
    border: 1px solid #f7f7f7;
    padding: 1rem;
    }
     </style>

@endpush
@push('script')
    @push('script')
        <script>
            (function($) {
                "use strict";
                @isset($permissions)
                    $('input[name="permissions[]"]').val(@json($permissions));
                @endif
            })(jQuery);
        </script>
    @endpush
@endpush