@extends('admin.layouts.app')
@section('panel') 

@if (isset($gpsdeviceedit))


<div class="col-xl-12 mx-auto">
    <div class="card">
        <div class="card-header px-4 py-3 bg-transparent">
            <h5 class="mb-0">{{$pageTitle}}</h5>
        </div>
        <div class="card-body p-4">
          <form action="{{route('admin.device.save-unlink-device-to-customer') }}" method="post" class="row g-3 needs-validation" novalidate id="roleform">
            <input type="hidden" name="gps_device_id" value="{{ $gpsdeviceedit->id ?? '0' }}" />
            @csrf
            <div class="col-md-4">
                    <label for="bsValidation11" class="form-label">Customer<span class="text-danger">*</span></label>
                    <select id="bsValidation11" class="form-select customer_id" name="customer_id" id="customer_id" required readonly>
                      {{-- <option value="">Select Customer</option> --}}
                      @foreach ($customersWithRole as $customersRole)
                        @if (isset($gpsdeviceedit) && $gpsdeviceedit->admin_id == $customersRole->cid)
                        <option value="{{ $customersRole->cid }}" @if(isset($gpsdeviceedit) && $gpsdeviceedit->admin_id == $customersRole->cid) selected @endif>{{ $customersRole->name }}</option>
                        @endif
                        @endforeach
                  </select>
                    <div class="invalid-feedback">
                        Please select a Customer.
                    </div>
                </div>
                
                <div class="col-md-4">
                    <label for="bsValidation11" class="form-label">Device ID<span class="text-danger">*</span></label>
                    <select id="bsValidation11" class="form-select select2" name="device_id[]" id="device_id">
                        <option value="">Choose...</option>
                        @foreach ($gpsdevices as $gpsdevice)

                        <option value="{{ $gpsdevice->id }}" @if(isset($gpsdeviceedit) && $gpsdeviceedit->id == $gpsdevice->id) selected @endif>{{ $gpsdevice->device_id }}</option>
                          {{-- <option value="{{ $gpsdevice->id }}">{{ $gpsdevice->device_id }}</option> --}}
                         @endforeach
                    </select>
                    <div class="invalid-feedback">
                        Please select a Device ID.
                    </div>
                </div>

                <div class="col-md-12 text-end  align-self-center ">
                    <button type="submit" class="btn btn-primary px-4">Save</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endif
</div>

<!--end row-->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
              <table id="example2" class="table table-striped table-borderd dc-table" style="border-collapse: collapse!important;">
                <thead>
                    <tr>
                        <th>Sr No.</th>
                        @can(['admin.device.status-mapdevice'])
                        <th>Operation</th>
                        @endcan                        
                        <th>Customer Name</th>
                        <th>Device ID</th>
                        <th>Device Type</th>
                        <th>Sim Card No.</th>
                        <th>IMEI No.</th>
                        <th>Customer No</th>
                        <th>Asset No</th>
                        <th>Registration Time</th>
                        <th>Expire Date</th>
                        <th>Authorization Info.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mapdevices as $mapdevice)
                    @php
                        $trip_info = array();
                        $trip_info['address'] = '';
                        $tc_devices = DB::table('tc_devices')->where('uniqueid', $mapdevice->device_id)->first();
                        if (isset($tc_devices) && !empty($tc_devices)) {
                          $positionid = (isset($tc_devices->positionid)) ? $tc_devices->positionid : 0;
                          if (!empty($positionid) && isset($positionid)) {
                            $tc_positions = DB::table('tc_positions')->where('id', $positionid)->first();
                            if (isset($tc_positions->attributes) && !empty($tc_positions->attributes)) {
                              $trip_info['address'] = (isset($tc_positions->address) && !empty($tc_positions->address)) ? $tc_positions->address : '';
                            }
                          } else {
                            $trip_info['address'] = '';
                          }
                        }
                        if (isset($tc_devices->id)) {
                          $tc_device_id = $tc_devices->id;
                        } else {
                          $tc_device_id = '';
                        }
                    @endphp
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        @can(['admin.device.status-mapdevice'])
                        <td>

                          <a class="" href="{{ route('admin.device.unlink-map-device-to-customer', ['id' => $mapdevice->id]) }}">
                            <img class="p-1" src="{{ asset('assets/icon/edit.png')}} " />
                          </a>

                          {{-- @can('admin.device.status-mapdevice')
                            @if ($mapdevice->status == 'enable')
                                <a class="confirmationBtn cursor-pointer" data-action="{{ route('admin.device.status-mapdevice', ['id' => $mapdevice->id]) }}" data-question="@lang('Are you sure to disable this Map Device To Customer?')">
                                  <img class="p-1" src="{{asset('assets/icon/enable.png')}}" />
                            @else
                                <a class="confirmationBtn cursor-pointer" data-action="{{ route('admin.device.status-mapdevice', ['id' => $mapdevice->id]) }}" data-question="@lang('Are you sure to enable this Map Device To Customer?')">
                                  <img class="p-1" src="{{asset('assets/icon/disable.png')}}" />
                            @endif    
                          @endcan --}}
                        </td>
                        @endcan
                        <td>{{$mapdevice->customername}}</td>
                        <td>{{$mapdevice->device_id}}</td>
                        <td>{{$mapdevice->device_type}}</td>
                        <td>{{$mapdevice->sim_no}}</td>
                        <td>{{$mapdevice->imei_no}}</td>
                        <td>{{$mapdevice->customer_no}}</td>
                        <td>{{$mapdevice->asset_no}}</td>
                        <td>{{$mapdevice->created_at}}</td>
                        <td>{{ date('d-m-Y', strtotime($mapdevice->expirydate)) }}</td>
                        <td class="text-center device-info">
                          <img class="cursor-pointer p-1 dropdown-toggle dropdown-toggle-split js-device-details" data-device-id="{{$tc_device_id }}" data-bs-toggle="dropdown"  data-toggle="dropdown" data-placement="top" title="Device Details" src="{{asset('assets/icon/device-detail.png')}}" /> 
                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                            <div class="container text-center ">
                              <div class="text-start">
                                <h6 style="font-size:13px;">Device Details</h6>
                              </div>
                              <div class="col-12">
                                <div class="row">
                                  <div class="col-6 pb-1 px-1 border-end">
                                    <img  src="{{asset('assets/icon/battery.png')}}" />
                                    <label class="d-block device-title"> <span class="js-battery-percentage"></span>%</label>
                                  </div>
                                  <div class="col-6 pb-1 px-1">
                                    <img src="{{asset('assets/icon/account-online.png')}}" />
                                    <label class="d-block device-title js-device-status"></label>
                                  </div>
                                </div>
                                <hr class="my-0">
                    
                                <div class="row">
                                  <div class="col-6 pt-1 px-1 border-end">
                                    <img  src="{{asset('assets/icon/round-lock.png')}}" />
                                    <label class="d-block device-title js-device-lock-status "> </label>
                                  </div>
                                  
                                  <div class="col-6 pt-1 px-1">
                                    <img  src="{{asset('assets/icon/speedometer.png')}}" />
                                    <label class="d-block device-title"> <span class="js-vehical-speed"> </span> Km/h</label>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          @if($mapdevice->asid !='' && !empty($mapdevice->asid) && isset($mapdevice->asid))         
                            <a class="" href="{{route('admin.trips.trip-details', ['id'=>$mapdevice->asid,'trip_id' =>  $mapdevice->current_trip_id ] )}}">
                              <img class="p-1" data-toggle="tooltip" data-placement="top" title="Trip Details"  src="{{asset('assets/icon/trip-summary.png')}}" />
                            </a>
                          @endif

                          @if($mapdevice->asid !='' && !empty($mapdevice->asid) && isset($mapdevice->asid))         
                            <a href="{{route('admin.device.live-tracking', ['id' => $mapdevice->asid])}}"><img class="p-1" src="{{asset('assets/icon/live-tracking.png')}}" />
                            </a>
                          @endif
                          </td>
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
{{-- <script src="{{ asset("/assets/select2%404.1.0-rc.0/dist/js/select2.min.js") }}"></script> --}}
<script src="{{ asset("/assets/plugins/select2/js/select2-custom.js") }}"></script>
     <script src="{{ asset("/assets/plugins/datatable/js/jquery.dataTables.min.js") }}"></script>
     <script src="{{ asset("/assets/select2/dist/js/select2.min.js") }}"></script>

@endpush
 @push('style-lib')
 {{-- <link rel="stylesheet" href="{{ asset("assets/select2%404.1.0-rc.0/dist/css/select2.min.css") }}" /> --}}
 <link rel="stylesheet" href="{{ asset("assets/select2-bootstrap-5-theme%401.3.0/dist/select2-bootstrap-5-theme.min.css") }}" />
 <link rel="stylesheet" href="{{ asset("/assets/select2/dist/css/select2.min.css") }}" />

 <style>
    table thead tr th {
      background-color: #2E3192 !important;
      color: #fff!important;
    }
    table tbody tr td {
      text-align: center;
    }
    .device-info .dropdown-menu {
      border: none;
      --bs-dropdown-min-width: 11rem;
    }
    .device-title {
      font-size: 13px;
    }
    .btn-sm{
      --bs-btn-padding-y: 0.1rem;
    }
    .select2-container .select2-selection--single {
      height: 36px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: 34px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
      top: 60%;
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
     $(document).ready(function () {
        $('.select2').select2();
    });
    $(document).ready(function() {
    var table = $('#example2').DataTable({
      lengthChange: false,
      "ordering": false,
      buttons: [{
        extend: 'copy',
        exportOptions: {
            columns: [0,2, 3, 4, 5, 6, 7, 8, 9,10] 
        }
      },
      {
        extend: 'excel',
        exportOptions: {
            columns: [0,2, 3, 4, 5, 6, 7, 8, 9,10] 
        }
      },
      {
        extend: 'pdf',
        exportOptions: {
            columns: [0,2, 3, 4, 5, 6, 7, 8, 9,10] 
        }
      },
      {
        extend: 'print',
        exportOptions: {
            columns: [0,2, 3, 4, 5, 6, 7, 8, 9,10] 
        }}
    ]
  });
  table.buttons().container().appendTo( '#example2_wrapper .col-md-6:eq(0)');

});
 
 </script>
 <script>
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
<script>
  // $(".datepicker").flatpickr();

  $(document).on('click','.js-device-details',function() {
  const deviceId = $(this).attr('data-device-id');
  $this = $(this);
  $.ajax({
    type: "POST",
    url: "{{ route('admin.trips.device-details') }}",
    headers: {
      'X-CSRF-TOKEN': $('input[name="_token"]').val()
    },
    data: {deviceId},
    dataType: "JSON",
    success: function (response) {
      console.log(response);
      if(response.batteryLevel !== '' && typeof response.batteryLevel !== "undefined"){ batteryLevel = response.batteryLevel;}else{batteryLevel = 0;}
      if(response.status !== '' && typeof response.status !== "undefined"){ status = response.status;}else{status = '';}
      if(response.speed !== '' && typeof response.speed !== "undefined"){ speed = response.speed;}else{speed = 0;}
      if(response.lock !== '' && typeof response.lock !== "undefined"){ lock = response.lock;}else{lock = '';}
        $this.closest('td').find('.js-battery-percentage').text(batteryLevel);
        $this.closest('td').find('.js-device-status').text(status);
        $this.closest('td').find('.js-device-lock-status').text(lock);
        $this.closest('td').find('.js-vehical-speed').text(speed);

      }
  });
});
</script>
 @endpush
 