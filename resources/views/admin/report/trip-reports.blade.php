@extends('admin.layouts.app')
@section('panel')
<div class="row">
  <div class="col-xl-12 mx-auto">
    <div class="card">
      <div class="card-header px-4 py-3 bg-transparent">
        <h5 class="mb-0">Trips Reports</h5>
      </div>
      <div class="card-body p-4">
        <form action="" class="row g-3" method="post" id="trip_report">
          
          <div class="col-md-3">
            <label for="bsValidation4" class="form-label">Trip ID</label>
              <select id="trip_id" class="form-select select2" name="trip_id">
                 <option selected value >Select Trips</option>
                @foreach ($trips as $trip)
                    <option value="{{ $trip->trip_id }}">{{ $trip->trip_id }}</option>
                @endforeach 
              </select>
          </div>
            <div class="col-md-3">
                <label class="form-label required">From Date</label>
                <input type="text" name="from_date" class="form-control datepicker" value=""
                    id="from_date">
            </div>

            <div class="col-md-3">
                <label class="form-label required">To Date</label>
                <input type="text" name="to_date" class="form-control datepicker" value=""
                    id="to_date">
            </div>

          <div class="col-md-3 text-md-center  align-self-end ">
            <div class="dropdown">
              <button class="btn btn-primary w-50 js-filter-trip" type="button"> <span class="material-symbols-outlined">filter_alt </span> Filter</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="card">

  <div class="card-header px-4 py-3 bg-transparent d-flex justify-content-between align-items-center">

    <h5 class="mb-0">Trips</h5>

    <div class="col-md-6 col-lg-12 d-flex justify-content-end" style="width: 95%;">
        <a class="btn btn-primary" style="width: 45px; padding: 0px; background: transparent; border: 1px solid #4caf50;" onclick="redirect()">
            <img width="35" height="35" src="https://img.icons8.com/color/48/ms-excel.png" alt="ms-excel"/>
        </a>
        <a class="btn btn-primary mx-2" style="width: 45px; padding: 0px; background: transparent; border: 1px solid #ff5722;" onclick="redirects()">
            <img width="26" height="26" style="vertical-align: -webkit-baseline-middle;" src="https://img.icons8.com/color/48/pdf.png" alt="pdf"/>
        </a>
    </div>
    
</div>


  <div class="card-body">
    <div class="table-responsive">
      <table id="trip-report-table" class="table table-striped table-borderd dc-table" style="border-collapse: collapse!important;">
        <thead>
          <tr>
            <th>Action</th>
            <th>Sr No.</th>
            <th>Trip ID</th>
            <th>Device Status</th>
            <th>Cargo Type</th>
            <th>Shipment Type</th>
            <th>Location</th>
            {{-- <th style="max-width: 200px;">Current Address</th> --}}
            <th>Driver name</th>
            <th>Vehicle No</th>
            <th>Contact No</th>
            <th>Start Date</th>
            <th>Exp Arrival Date</th>
            <th>Trip Comp. Date</th>
            <th>Last Update At</th>
            <th>Trip Status</th>
         </tr>
        </thead>
      
      </table>
    </div>
  </div>
</div>



@endsection


@push('script-lib')
<script src="{{ asset("/assets/plugins/datatable/js/jquery.dataTables.min.js") }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset("/assets/select2/dist/js/select2.min.js") }}"></script>

@endpush
@push('style-lib')
<link href="{{ asset("/assets/flatpickr/dist/flatpickr.min.css") }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset("/assets/select2/dist/css/select2.min.css") }}" />

<style>
  table thead tr th {
    background-color: #2E3192 !important;
    color: #fff !important;
  }
  #trip-report-table tr td:nth-child(8) {
    max-width: 200px;
    white-space: inherit;
  }
    #trip-report-table_filter{
            margin-bottom: 10px!important;
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
</style>
@endpush

@push('script')

<script>
   $(document).ready(function () {
        $('.select2').select2();
    });

        $(".datepicker").flatpickr();

    var table = $('#trip-report-table').DataTable({
    "scrollX": true,
    "dom": 'frtip',
    // "dom": 'frt<"dt-buttons"B><"clear">ip',
    "lengthMenu": [[25, 50, 75, 100, 125,150, -1],
      [ '25 rows', '50 rows', '75 rows',  '100 rows',  '125 rows',  '150 rows', 'Show all' ]
    ],
    "paging": true,
    "iDisplayLength": 10,
    processing: true,
    serverSide: true,
      "ajax": {
        "url": "{{ route('admin.reports.get.trip-report') }}",
          "type": "POST",
          'headers': {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
          "data":function(d) {
            d.trip_id = $("#trip_id").val(),
            d.from_date = $('#from_date').val(),
            d.to_date = $('#to_date').val()
          },
      },
      
      "columnDefs": [{
        "targets": [0],
        "orderable": false
      }],
     
  });

  $(".js-filter-trip").click(function() {
    const status = $("#trip_report").valid();
    if(status == true) {
      table.draw();
    }
  });
  
   function redirect() {
            var params = {
                trip_id: $('#trip_id').val(),
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val()
            };

            var url = "{{ url('admin/reports/excel-trips-reports') }}";

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

        function redirects() {
            var params = {
                trip_id: $('#trip_id').val(),
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val()
            };

            var url = "{{ url('admin/reports/pdf-trips-reports') }}";

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
