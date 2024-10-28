@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="card">
                <div class="card-header px-4 py-3 bg-transparent">
                    <h5 class="mb-0">Alarm Reports</h5>
                </div>
                <div class="card-body p-4">
                    <form action="" class="row g-3" method="post" id="alarm_report" novalidate="novalidate">
                        <div class="col-md-3">
                            <label for="bsValidation4" class="form-label">Device</label>
                            <select id="device_id" class="form-select select2" name="device_id">
                                <option selected value>Select Device</option>
                                @foreach ($gpsdevices as $gpsdevice)
                                    <option value="{{ $gpsdevice->device_id }}">{{ $gpsdevice->device_id }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-md-3">
                            <label for="bsValidation4" class="form-label">Trip ID</label>
                           <select id="trip_list" class="form-select select2" name="trip_id">
                                 <option selected value >Select Trips</option>
                                @foreach ($trips as $trip)
                                    <option value="{{ $trip->trip_id }}">{{ $trip->trip_id }}</option>
                                @endforeach 
                            </select>
                            <input type="hidden" name="trip_id" id="trip_id">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label required">From Date</label>
                            <input type="text" name="from_date" class="form-control datepicker" value=""
                                id="from_date">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label required">To Date</label>
                            <input type="text" name="to_date" class="form-control datepicker" value=""
                                id="to_date">
                        </div>
                        <div class="col-md-2 text-md-center  align-self-end ">
                            <div class="dropdown">
                                <button class="btn btn-primary w-50 js-filter-trip" type="button" id="alarms"> <span
                                        class="material-symbols-outlined">filter_alt </span> Filter</button>
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
            {{-- <div class="col-md-6 col-lg-12" style="display: flex;justify-content: end;margin-left: -24%; margin-bottom: -28px;">
                <a class="btn btn-primary" style="width: 40px;padding: 0px;" onclick="redirect()"><i style="font-size: 21px;" class="bi bi-file-earmark-spreadsheet"></i></a>
                <a class="btn btn-primary mx-2" style="width: 40px;padding: 0px;" onclick="redirects()"><i style="font-size: 21px;" class="bi bi-file-earmark-pdf"></i></a>

            </div> --}}
            <div class="table-responsive">
                <table id="alarms-report-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Trip ID</th>
                            <th>Rf Id Card Number</th>
                            <th>Alarm</th>
                            <th>Cargo Type</th>
                            <th>Shipment Type</th>
                            <th>Location</th>
                            <th>Current Address</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Driver name</th>
                            <th>Vehicle No</th>
                            <th>Contact No</th>
                            <th>Alarm Date</th>
                            <th>Created Date</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection



@push('script-lib')
    <script src="{{ asset('/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset("/assets/select2/dist/js/select2.min.js") }}"></script>

@endpush
@push('style-lib')
    <link href="{{ asset('/assets/flatpickr/dist/flatpickr.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset("/assets/select2/dist/css/select2.min.css") }}" />

    <style>
        table thead tr th {
            background-color: #2E3192 !important;
            color: #fff !important;
        }
        #alarms-report-table_filter{
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
         
        #alarms-report-table tr td:nth-child(4) {
        width: 2000px;
        white-space: inherit;
      }
      #alarms-report-table tr td:nth-child(8) {
        width:500px;
        white-space: inherit;
      }
     
    </style>
@endpush
@push('script')
    <script>
         $(document).ready(function () {
        $('.select2').select2();
    });
        $(".datepicker").flatpickr();

        (function() {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()


        $(document).ready(function() {
            var table = $('#alarms-report-table').DataTable({
                // "scrollX": true,
                "dom": 'frtip',
                "lengthMenu": [
                    [25, 50, 75, 100, 125, 150, -1],
                    ['25 rows', '50 rows', '75 rows', '100 rows', '125 rows', '150 rows', 'Show all']
                ],
                "paging": true,
                "iDisplayLength": 10,
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ route('admin.reports.alrams.trips') }}",
                    "type": "POST",
                    'headers': {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    "data": function(d) {
                        d.device_id = $("#device_id").val(),
                            d.trip_id = $("#trip_list").val(),
                            d.from_date = $('#from_date').val(),
                            d.to_date = $('#to_date').val()
                    },
                },
                "ordering": true,
                order: [
                    [1, 'asc']
                ],

            });
            $('[data-toggle="tooltip"]').tooltip();

            $(".js-filter-trip").click(function() {
                const status = $("#alarm_report").valid();
                if (status == true) {
                    table.draw();
                }
            });
        });


        function redirect() {
            var params = {
                device_id: $('#device_id').val(),
                trip_id: $('#trip_list').val(),
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val()
            };

            var url = "{{ url('admin/reports/excel-alarm-reports') }}";

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
                device_id: $('#device_id').val(),
                trip_id: $('#trip_list').val(),
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val()
            };

            var url = "{{ url('admin/reports/pdf-alarm-reports') }}";

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


        $(document).on('change', '#device_id', function () {
    var device_id = $('#device_id').val();
    if (device_id) {
        var url = "{{url('admin/reports/get-device-per-trip')}}";
        var csrfToken = "{{csrf_token()}}";

        $.ajax({
            type: "post",
            url: url,
            data: {
                device_id: device_id,
                _token: csrfToken
            },
            success: function(response) {
                const myArr = JSON.parse(response);
                var trips = myArr.trips;
                var ajaxDiv = $('#trip_list');
                var html = '<option selected value disabled>Select Trips</option>';
                         for (let i = 0; i < trips.length; i++) {
                            const element = trips[i];
                            html += '<option value="' + element.trip_id + '">' + element.trip_id + '</option>';
                         }
                       
                        ajaxDiv.html(html);
                    }

        });
    }
});

    </script>
@endpush


