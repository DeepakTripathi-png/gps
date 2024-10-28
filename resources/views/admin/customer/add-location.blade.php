@extends('admin.layouts.app')
@section('panel') 
      <div class="row">
          <div class="col-xl-12 mx-auto">
              <div class="card">
                  <div class="card-header px-4 py-3 bg-transparent">
                      <h5 class="mb-0">{{$pagetitle}}</h5>
                  </div>
                  <div class="card-body p-4">
                      <form action="{{ isset($location) ? route('admin.locations.update-location', ['id' => $location->id]) : route('admin.locations.save-location') }}" method="post" class="row g-3 needs-validation" novalidate id="roleform">
                          @if (isset($location))
                            @method('PATCH') 
                          @endif
                            @csrf       
                          <div class="col-md-4">
                              <label for="bsValidation1" class="form-label required">Location Port ID <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="bsValidation1" name="location_port_id" value="{{ old('location_port_id', $location->location_port_id ?? '') }}" placeholder="Location Port ID" required>
                              <div class="invalid-feedback">
                                 Please select a valid Location Port ID.
                              </div>
                          </div>
                          <div class="col-md-4">
                              <label for="bsValidation2" class="form-label required">Location ICD/Port Name <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="location_port_name" name="location_port_name" value="{{ old('location_port_name', $location->location_port_name ?? '') }}" placeholder="Location Name/Port Name" required>
                              <div class="invalid-feedback">
                                  Please enter a valid Location ICD/Port Name.
                                </div>
                          </div>
                          <div class="col-md-4">
                              <label for="bsValidation3" class="form-label required">Location Address <span class="text-danger">*</span></label>
                              <textarea class="form-control" id="location_address" name="location_address" value="{{ old('location_address', $location->location_address ?? '') }}" placeholder="Location Address ..." rows="1" required>{{ old('location_address', $location->location_address ?? '') }}</textarea>
                              <div class="invalid-feedback">
                                  Please enter a valid Location address.
                              </div>
                          </div>
                          <div class="col-md-4">
                              <label for="bsValidation4" class="form-label required">Location Lat <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="location_lat" readonly="true" name="location_lat" placeholder="Location Lat" value="{{ old('location_lat', $location->location_lat ?? '') }}" required>

                              <div class="invalid-feedback">
                                  Please enter a valid Location Lat.
                              </div>
                          </div>
                          <div class="col-md-4">
                              <label for="bsValidation5" class="form-label required">Location Long <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="location_long" readonly="true" name="location_long" placeholder="Location Long" value="{{ old('location_long', $location->location_long ?? '') }}" required>

                              <div class="invalid-feedback">
                                  Please enter a valid Location Long.
                              </div>
                          </div>

                           <div class="col-md-4">
                                <label for="bsValidation7" class="form-label required"> Location Type <span class="text-danger">*</span></label>
                                <select id="bsValidation7" class="form-select"  name="location_type"  required >
                                    <option selected  value="" >Select Location Type</option>
                                    @if(@isset($location))                                 
                                    <option value="ICD"  {{old('location_type' , $location->location_type) == 'ICD'? 'selected': ''}}>ICD</option>
                                    <option value="Port" {{old('location_type',$location->location_type) == 'Port' ? 'selected': ''}} >Port</option>
                                    @else
                                    <option value="ICD">ICD</option>
                                    <option value="Port">Port</option>
                                    @endif
                                </select>
                                <div class="invalid-feedback">
                                Please select a valid Location Type.
                                </div>
                            </div>

                          <div class="col-md-4">
                              <label for="bsValidation6" class="form-label"> Authorized Port Person <span class="text-danger">*</span></label>
                              <select id="bsValidation11" class="form-select customer_id js-customer-id" name="customer_id[]" id="customer_id" multiple required data-placeholder="Authorized Port Person">
                                  <option value="">Select Port Authorized Person</option>
                                  {{-- @if(in_array(old('customer_id', is_array($location->admin_id) ? $location->admin_id : ''), [$customersRole->cid])) --}}
                                  @php
                                      $selectedIds = explode(',', $location->admin_id ?? '');
                                  @endphp
                                  @foreach ($customersWithRole as $customersRole)
                                    @if(in_array($customersRole->cid,$selectedIds))
                                        <option value="{{ $customersRole->cid }}" selected> {{ $customersRole->name }} </option>
                                    @else
                                      <option value="{{ $customersRole->cid }}">{{ $customersRole->name }}</option>
                                    @endif 
                                  @endforeach
                              </select>
                              <div class="invalid-feedback">
                                 Please select a valid  Authorized Person.
                              </div>
                          </div>

                        

                          {{-- @if (auth('admin')->user()->role_id == 0) --}}
                                <div class="col-md-4">
                                    <label class="form-label"> Authorized Customs Person <span class="text-danger">*</span></label>
                                    <select class="form-select js-custom-office-id" name="custom_office_id[]" id="custom_office_id" multiple  data-placeholder="Authorized Customs Person">
                                        <option value="">Select Authorized Customs Person</option>
                                        @php
                                            $selectedIdsCustoms = explode(',', $location->customs_admin_id ?? '');
                                        @endphp
                                        @foreach ($customersWithRoleCustoms as $customsRole)
                                        @if(in_array($customsRole->cid,$selectedIdsCustoms))
                                            <option value="{{ $customsRole->cid }}" selected> {{ $customsRole->name }} </option>
                                        @else
                                            <option value="{{ $customsRole->cid }}">{{ $customsRole->name }}</option>
                                        @endif 
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                    Please select a valid  Authorized Person.
                                    </div>
                                </div>  
                            {{-- @endif --}}

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
      <!--end row-->

      <div class="card">
          <div class="card-body">
              <div class="table-responsive">
                <table id="example2" class="table table-striped table-borderd dc-table" style="border-collapse: collapse!important;">
                      <thead>
                          <tr>
                              <th>Sr No.</th>
                              <th>Location Port ID</th>
                              <th>Location ICD/Port Name</th>
                              <th>Authorized Port Person</th>
                              <th>Authorized Customs Person</th>
                              <th>Location Type</th>
                              <th>Address</th>
                              @can(['admin.locations.edit-location', 'admin.locations.status-location'])
                              <th>Action</th>
                              @endcan
                           </tr>
                      </thead>
                      <tbody>
                          @foreach ($locations as $location)
                          <tr>
                              <td>{{ $loop->index + 1 }}</td>
                              <td>{{$location->location_port_id}}</td>
                              <td>{{$location->location_port_name}}</td>
                              <td>{{$location->customer_name}}</td>
                              <td>{{$location->customs_name}}</td>
                              <td>{{$location->location_type}}</td>
                              <td>{{$location->location_address}}</td>
                               @can(['admin.locations.edit-location', 'admin.locations.status-location'])
                                <td>
                                    <div class="button--group">
                                        @can('admin.locations.edit-location')
                                            <a class="" href="{{ route('admin.locations.edit-location', ['id' => $location->id]) }}"><img class="p-1" src="{{asset('assets/icon/edit.png')}}" /></a>
                                        @endcan
                                        @can('admin.locations.status-location')
                                            @if ($location->status == 'enable')
                                                {{-- <button class="btn btn-sm btn-success ms-1 confirmationBtn" data-action="{{ route('admin.locations.status-location', ['id' => $location->id]) }}" data-question="@lang('Are you sure to disable this Locations?')">
                                                    <i class="bi-eye"></i>@lang('Enable')
                                                </button> --}}

                                                <a class="confirmationBtn cursor-pointer" data-action="{{ route('admin.locations.status-location', ['id' => $location->id]) }}" data-question="@lang('Are you sure to disable this Locations?')">
                                                    <img class="p-1" src="{{ asset('assets/icon/enable.png')}} " />
                                                </a>

                                            @else
                                                {{-- <button class="btn btn-sm btn-danger ms-1 confirmationBtn" data-action="{{ route('admin.locations.status-location', ['id' => $location->id]) }}" data-question="@lang('Are you sure to enable this Location?')">
                                                    <i class="bi-eye-slash"></i>@lang('Disable')
                                                </button> --}}

                                                <a class="confirmationBtn cursor-pointer" data-action="{{ route('admin.locations.status-location', ['id' => $location->id]) }}" data-question="@lang('Are you sure to enable this Location?')">
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
    <script src="{{ asset("/assets/select2/dist/js/select2.min.js") }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=AIzaSyBvNFKRBGD7GiXGArCB8wXu-fnrXHIFYoc"></script>
     
@endpush
 @push('style-lib')
 <link rel="stylesheet" href="{{ asset("/assets/select2/dist/css/select2.min.css") }}" />
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
    .form-control:read-only {
        background-color: var(--bs-secondary-bg);
        opacity: 1;
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
    $(document).ready(function() {
        $('#example').DataTable();
      } );
 </script>
 <script>

    $(document).ready(function() { 
        $(".js-customer-id").select2();
        $(".js-custom-office-id").select2();

        var table = $('#example2').DataTable({
            lengthChange: false,
    "ordering": false,
      buttons: [
        {
          extend: 'copy',
          exportOptions: {
              columns: [0, 1, 2, 3, 4, 5] 
          }
        },
        {
            extend: 'excel',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5] 
            }
        },
        {
            extend: 'pdf',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5] 
            }
        },
        {
            extend: 'print',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5] 
            }
        }
    ]
        });
        table.buttons().container().appendTo( '#example2_wrapper .col-md-6:eq(0)');
  $('[data-toggle="tooltip"]').tooltip();
});
 
 </script>
 <script>
    var isEditMode = {{ json_encode($isEditMode) }};

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

    function initialize() {
        var addressInput = document.getElementById('location_address');
        var autocomplete = new google.maps.places.Autocomplete(addressInput);
        // autocomplete.setTypes(['geocode']);

        var placeSelected = false;
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();

            placeSelected = !!place.geometry;

            if (!place.geometry) {
                $("#location_address").val('');
                return;
            }

            // Set the latitude and longitude values
            var latitude = place.geometry.location.lat();
            var longitude = place.geometry.location.lng();

            // You can use these latitude and longitude values as needed
            // console.log('Latitude: ' + latitude);
            // console.log('Longitude: ' + longitude);
            $("#location_lat").val(latitude);
            $("#location_long").val(longitude);


            // Rest of your code...

            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');

                // Use the 'address' variable as needed
               // console.log('Selected Address: ' + address);
            }
        });

        addressInput.addEventListener('input', function () {
            // User typed something, but no place is selected
            placeSelected = false;
        });

        document.addEventListener('click', function (event) {
            // Check if the click is outside the autocomplete dropdown and no place is selected
            if (!event.target.matches('.pac-container *') && !placeSelected) {
                if (!isEditMode) {
                // Clear the textboxes
                    $("#location_address").val('');
                    $("#location_lat").val('');
                    $("#location_long").val('');
                }
            }
        });
       
    }

    google.maps.event.addDomListener(window, 'load', initialize);
    
 </script>
 @endpush
 