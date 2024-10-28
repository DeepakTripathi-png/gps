@extends('admin.layouts.app')
@section('panel')
  <div class="col-xl-12 mx-auto">
    <div class="card">
      <div class="card-header px-4 py-3 bg-transparent">
        <h5 class="mb-0">{{$pageTitle}}</h5>
      </div>
      <div class="card-body p-4">
        <form class="row g-3 needs-validation" action="{{ route('admin.device.import_exel')}}" enctype="multipart/form-data" method="post" novalidate>
          @csrf
          <div class="col-md-5">
            <label for="formFile" class="form-label">Upload Excel Sheet</label>
            <input class="form-control" type="file" name="device_upload" id="formFile">
            <div>
              <a href="{{ asset('template/import_devicess_sample.xlsx') }}" class="mt-2 d-block underline" style="text-decoration: underline;">Download Template</a>
            </div>
          </div>
          <div class="col-md-2 text-md-center  align-self-center ">
            <button type="submit" class="btn btn-primary px-4">Upload</button>
          </div>
        </form>
      </div>
    </div>
  </div>  
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table id="example2" class="table table-striped table-borderd dc-table" style="border-collapse: collapse!important;">
          <thead>
            <tr>
              <th>Sr No</th>
              @can(['admin.device.status-mapdevice'])
              <th>Operation</th>
              @endcan
              <th>Trip ID</th>
              <th>Device ID</th>
              <th>Device Status</th>
              <th>Device Type</th>
              <th>Sim No.</th>
              <th>IMEI No.</th>
              <th>Swipe Card I</th> 
              <th>Swipe Card II</th> 
              <th>Registration Time</th> 
              <th>Authorization Info.</th>      
            </tr>
          </thead>
          <tbody>
            @foreach ($imports as $import)
            
            @php
                $trip_info = array();
                $trip_info['address'] = '';
                $tc_devices = DB::table('tc_devices')->where('uniqueid', $import->device_id)->first();
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
            @php
            $color = '';
            if ($import->device_status == 'online') {
              $color = 'text--success';
            } elseif ($import->device_status == 'offline') {
              $color = 'text--danger';
            } else {
              $color = 'text--danger';
            }
            @endphp
            <tr>
              <td>{{ $loop->index + 1 }}</td>
              @can(['admin.device.status-mapdevice'])
              <td>
                @can('admin.device.status-mapdevice')
                  @if ($import->status == 'enable')
                      <a class="confirmationBtn cursor-pointer" data-action="{{ route('admin.device.status-mapdevice', ['id' => $import->id]) }}" data-question="@lang('Are you sure to disable this Map Device To Customer?')">
                        <img class="p-1" src="{{asset('assets/icon/enable.png')}}" />
                      </a>
                  @else
                      <a class="confirmationBtn cursor-pointer" data-action="{{ route('admin.device.status-mapdevice', ['id' => $import->id]) }}" data-question="@lang('Are you sure to enable this Map Device To Customer?')">
                        <img class="p-1" src="{{asset('assets/icon/disable.png')}}" />
                      </a>
                  @endif    
                @endcan
              </td>
              @endcan
              <td>{{$import->current_trip_id}}</td>
              <td>{{$import->device_id}}</td>
              <td class="{{ $color }}">{{$import->device_status}}</td>
              <td>{{$import->device_type}}</td>
              <td>{{$import->sim_no}}</td>
              <td>{{$import->imei_no}}</td>
              <td>{{$import->swipe_cardone}}</td>
              <td>{{$import->swipe_cardtwo}}</td>
              <td>{{ $import->created_at->format('d-m-Y H:i:s') }}</td>
              <td class="text-center device-info">
                <img class="cursor-pointer p-1 dropdown-toggle dropdown-toggle-split js-device-details"  data-device-id="{{$tc_device_id }}" data-bs-auto-close="true" data-bs-toggle="dropdown" aria-expanded="false" data-toggle="dropdown" title="Device Details" src="{{asset('assets/icon/device-detail.png')}}" /> 
                <div class="dropdown-menu dropdown-menu-lg-end dropup ">
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

                @if($import->asid !='' && !empty($import->asid) && isset($import->asid))         
                  <a class="" href="{{route('admin.trips.trip-details', ['id'=>$import->asid,'trip_id' =>  $import->current_trip_id ] )}}">
                    <img class="p-1" data-toggle="tooltip" data-placement="top" title="Trip Details"  src="{{asset('assets/icon/trip-summary.png')}}" />
                  </a>
                @endif

                  {{-- <img class="p-1 device-lock-alert cursor-pointer" src="{{asset('assets/icon/round-lock.png')}}" /> --}}
                @if($import->asid !='' && !empty($import->asid) && isset($import->asid))         
                  <a href="{{route('admin.device.live-tracking', ['id' => $import->asid])}}">
                    <img class="p-1" src="{{ asset('assets/icon/live-tracking.png') }}" />
                  </a>
                @endif
              
                @if($import->asid !='' && !empty($import->asid) && isset($import->asid))
                  <a onclick="redirects('{{ $import->current_trip_id }}')" style="cursor: pointer;">
                    <img class="p-1"  data-toggle="tooltip" data-placement="top" title="Download"  src="{{asset('assets/icon/material_download.png')}}" />
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
  <script src="{{ asset("/assets/plugins/datatable/js/jquery.dataTables.min.js") }}"></script>
@endpush
@push('style-lib')
  <style>
    table thead tr th {
      background-color: #2E3192 !important;
      color: #fff!important;
    }
    .btn-sm{
      --bs-btn-padding-y: 0.1rem;
    }
    table tbody tr td {
      text-align: center;
    }
    /* .dropdown-menu.show {
      transform: unset !important;
    } */
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
  });
    
  $(document).ready(function() {
    var table = $('#example2').DataTable({
      lengthChange: false,
    "ordering": false,
      buttons: [ 'copy', 'excel', 'pdf', 'print'],
    });
    table.buttons().container().appendTo( '#example2_wrapper .col-md-6:eq(0)');
});

 $(".device-lock-alert").click(function() {
   $("#deviceNotification").modal('show');
 });
 $(".confirm-unlock-device").click(function() {
    $("#deviceNotification").modal('hide');
    success_noti();
 });

 function success_noti() {
    Lobibox.notify('success', {
      pauseDelayOnHover: true,
      continueDelayOnInactiveTab: false,
      position: 'top right',
      icon: 'bi bi-check-circle-fill',
      msg: 'Device Unlock Successfully.'
    });
  }
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

function redirects(tripId) {
  console.log('df');
    var params = {trip_id: tripId};

    var url = "{{ url('admin/reports/pdf-device-summary-reports') }}";
    var queryParams = Object.entries(params)
        .filter(([key, value]) => value !== '')
        .map(([key, value]) => `${key}=${value}`)
        .join('&');

    if (queryParams !== '') {
        url += '?' + queryParams;
        window.location.href = url;
    } else {
        console.log('All variables are empty. Do something else or provide a default URL.');
    }
}
</script>
@endpush