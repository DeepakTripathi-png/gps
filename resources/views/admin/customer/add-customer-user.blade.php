@extends('admin.layouts.app')
@section('panel') 
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="card">
                <div class="card-header px-4 py-3 bg-transparent">
                    <h5 class="mb-0">{{$pageTitle}}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ isset($customer) ? route('admin.customers.update-customer-user',['id' => $customer->id] ) : route('admin.customers.save-customer-user') }}" method="post" class="row g-3 needs-validation" novalidate id="roleform">
                        @if (isset($customer))
                        @method('PATCH') 
                        @endif
                        @csrf
                        <div class="col-md-4">
                            <label for="bsValidation1" class="form-label">Person Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="bsValidation1" name="customer_name"   placeholder="Customer Name" value="{{ old('customer_name', $customer->name ?? '') }}" required>
                            <div class="invalid-feedback">
                                Please enter a valid Customer Name.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="bsValidation2" class="form-label">Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="bsValidation2" placeholder="Email" name="customer_email" value="{{ old('customer_email', $customer->email ?? '') }}"  required>
                            <div class="invalid-feedback">
                                Please provide a valid email.
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <label for="bsValidation2" class="form-label">Secondary Email</label>
                            <input type="email" class="form-control" placeholder="Secondary Email" name="secondary_email" value="{{ old('secondary_email', $customer->secondary_email ?? '') }}" >
                            <div class="invalid-feedback">
                                Please provide a valid Secondary email.
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="bsValidation3" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="bsValidation3" placeholder="Mobile Number" pattern="[0-9]{10}"  name="customer_mobileno" value="{{ old('customer_mobileno', $customer->mobile_no ?? '') }}" required>
                            <div class="invalid-feedback">
                                Please enter a valid Mobile Number.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="bsValidation4" class="form-label">Role</label>
                            <select id="bsValidation4" class="form-select" required name="role_id">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    @if(old('role_id', $customer->role_id ?? '') == $role->id)
                                        <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                                    @else
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid Role.
                            </div>
                        </div>
                        
                        {{-- <div class="col-md-4">
                            <label for="bsValidation5" class="form-label">Related Company</label>
                            <input type="text" class="form-control" id="bsValidation5" placeholder="Related Company" name="related_company" value="{{ old('related_company', $customer->related_company ?? '') }}" required>
                            <div class="invalid-feedback">
                                Please enter a valid Related Company.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="bsValidation6" class="form-label">Gst No <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="bsValidation6" placeholder="Gst No" name="gst_no"  value="{{ old('gst_no', $customer->gst_no ?? '') }}"required>
                            <div class="invalid-feedback">
                                Please enter a valid Gst No.
                            </div>
                        </div> --}}
                        <div class="col-md-4">
                            <label for="bsValidation7" class="form-label">Username<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="bsValidation7" placeholder="Username" name="username" value="{{ old('username', $customer->username ?? '') }}" required>
                            <div class="invalid-feedback">
                                Please enter a valid Username.
                            </div>
                        </div>
                        @empty($customer)
                        <div class="col-md-4">
                            <label for="bsValidation8" class="form-label">Password<span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
                            <div class="invalid-feedback">
                                Please choose a password.
                            </div>
                        </div> 
                        <div class="col-md-4">
                            <label for="bsValidation9" class="form-label">Confirm Password<span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="cpassword" placeholder="Confirm Password" name="confirm_password"  required>
                            <div class="invalid-feedback">
                                Please choose a Confirm password.
                            </div>
                            <div class="text-danger" id="passwordMismatchError" style="display: none;">Passwords do not match with Confirm password.</div>
                        </div>   
                        @endif   
                        <div class="col-md-12"> 
                            <div class="d-md-flex align-items-end justify-content-end">
                                <button type="submit" class="btn btn-primary px-4">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example2" class="table table-striped table-borderd dc-table" style="border-collapse: collapse!important;">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Customer Name</th>
                            <th>Username</th>
                            <th>Email id</th>
                            <th>Mobile No</th>
                            <th>Role</th>
                            @can(['admin.customers.edit-customer-user', 'admin.customers.status-customer-user'])
                            <th>Action</th>
                            @endcan

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td class="text-align-left">{{$customer->name  }}</td>
                                <td>{{$customer->username}}</td>
                                <td>{{$customer->email}}</td>
                                <td>{{$customer->mobile_no}}</td>
                                <td>{{$customer->role_name}}</td>
                                @can(['admin.customers.edit-customer-user', 'admin.customers.status-customer-user'])
                                <td>
                                    <div class="button--group">
                                    @can('admin.customers.edit-customer-user')
                                    <a class="" href="{{ route('admin.customers.edit-customer-user', ['id' => $customer->id]) }}"><img class="p-1" src="{{asset('assets/icon/edit.png')}}" /></a>
                                    @endcan
                                    @can('admin.customers.status-customer-user')
                                    @if ($customer->status == 1)
                                        {{-- <button class="btn btn-sm btn-success ms-1 confirmationBtn" data-action="{{ route('admin.customers.status-customer-user', ['id' => $customer->id]) }}" data-question="@lang('Are you sure to disable this Customer User?')">
                                            <i class="bi-eye"></i>@lang('Enable')
                                        </button> --}}
                                        <a class="confirmationBtn cursor-pointer" data-action="{{ route('admin.customers.status-customer-user', ['id' => $customer->id]) }}" data-question="@lang('Are you sure to disable this Customer User?')">
                                            <img class="p-1" src="{{asset('assets/icon/enable.png')}}" />
                                        </a>
                                    @else
                                        {{-- <button class="btn btn-sm btn-danger ms-1 confirmationBtn" data-action="{{ route('admin.customers.status-customer-user', ['id' => $customer->id]) }}" data-question="@lang('Are you sure to enable this Customers User?')">
                                            <i class="bi-eye-slash"></i>@lang('Disable')
                                        </button> --}}
                                        <a class="confirmationBtn cursor-pointer" data-action="{{ route('admin.customers.status-customer-user', ['id' => $customer->id]) }}" data-question="@lang('Are you sure to enable this Customers User?')">
                                            <img class="p-1" src="{{asset('assets/icon/disable.png')}}" />
                                        </a>
                                    @endif
                                    @endcan
                                    </div>
                                </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
      <div id="confirmationModal" class="modal fade show" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Confirmation Alert!')</h5>
                    <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <form action="" method="POST" id="confirmation-form">
                    @csrf
                    <div class="modal-body">
                        <p class="question"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn-primary">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script-lib')
    <script src="{{ asset("/assets/plugins/datatable/js/jquery.dataTables.min.js") }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush
@push('style-lib')
<link href="{{ asset("/assets/flatpickr/dist/flatpickr.min.css") }}" rel="stylesheet">
    <style>
        table thead tr th {
            background-color: #2E3192 !important;
            color: #fff!important;
            text-align: center;
        }
        table tbody tr td {
        text-align: center;
        }
        .btn-sm{
            --bs-btn-padding-y: 0.1rem;
        }
</style>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            $(document).on('click', '.confirmationBtn', function() {
                var modal = $('#confirmationModal');
                let data = $(this).data();
                modal.find('.question').text(`${data.question}`);
                modal.find('form').attr('action', `${data.action}`);
                modal.modal('show');
            });
        })(jQuery);
    
        $(".datepicker").flatpickr();
        $(document).ready(function() {
            $('#example').DataTable();
        } );
        $(document).ready(function() {
            var table = $('#example2').DataTable({
                lengthChange: false,
                ordering: false,
                buttons: [
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6] 
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6] 
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6] 
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6] 
                        }
                    }
                ]
            });
            table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
            $('[data-toggle="tooltip"]').tooltip();
        });

        (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
            }
            form.classList.add('was-validated')
            }, false)
        })
        })()
    </script>
@endpush
  