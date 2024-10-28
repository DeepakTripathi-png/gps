@extends('admin.layouts.app')
@section('panel') 
        <div class="card">
            <div class="card-header px-4 py-3 bg-transparent">
                <h5 class="mb-0">{{$pagetitle}}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-borderd dc-table" style="border-collapse: collapse!important;">
                        <thead>
                          <tr>
                            @can(['admin.trips.edit-trip', 'admin.trips.trip-details'])
                              <th>Action</th>
                            @endcan
                            <th>Sr No.</th>
                            <th>Trip ID</th>
                            {{-- <th data-orderable="false">Device Status</th> --}}
                            <th data-orderable="false">Cargo Type</th>
                            <th data-orderable="false">Shipment Type</th>
                            <th data-orderable="false">Location</th>
                            <th data-orderable="false" style="max-width: 200px;">Last Address</th>

                            <th data-orderable="false">Latitude</th>
                            <th data-orderable="false">Longitude</th>
                             
                            <th data-orderable="false">Driver name</th>
                            <th data-orderable="false">Vehicle No</th>
                            <th data-orderable="false">Contact No</th>
                            <th data-orderable="false">Start Date</th>
                            <th data-orderable="false">Exp Arrival Date</th>
                            <th data-orderable="false">Trip Comp. Date</th>
                            <th data-orderable="false" class="text-center">Last Update At</th>
                            {{-- <th data-orderable="false">Trip Status</th> --}}
                          </tr>
                        </thead>
                      
                    </table>
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
 .preview{
  font-weight: 800; 
  font-size: 16px;
 }
  #example2 tr td:nth-child(7) {
    max-width: 200px;
    white-space: inherit;
  }
</style>
@endpush
@push('script')
<script>

$(document).ready(function() {
 var table = $('#example2').DataTable({
        "scrollX": true,
		    "dom": 'Bfrtip',
        "lengthMenu": [[25, 50, 75, 100, 125,150, -1],
          [ '25 rows', '50 rows', '75 rows',  '100 rows',  '125 rows',  '150 rows', 'Show all' ]
        ],
        "paging": true,
        "iDisplayLength": 10,
        processing: true,
        serverSide: true,
     "ajax": {
          "url": "{{ route('admin.trips.get.completed.trips') }}",
          "type": "POST",
          'headers': {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
        },
          buttons: [
          {
            extend: 'excel',
            exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9,10,11,12,13] 
            }
          },
          {
            extend: 'print',
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9,10,11,12,13] 
            }
          }
        ]
 });
 table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
 $('[data-toggle="tooltip"]').tooltip();
});

  //$(".datepicker").flatpickr();

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