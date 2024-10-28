@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="card">
                <div class="card-header px-4 py-3 bg-transparent">
                    <h5 class="mb-0">Lock & Unlock Reports</h5>
                </div>
                <div class="card-body p-4">
                    <form class="row g-3" method="post" id="trip_report" novalidate="novalidate">
                        <div class="col-md-3">
                            <label class="form-label">Trip ID </label>
                            <select class="form-select select2" name="trip_id[]" id="trip_id" multiple>
                              <option value="">Choose...</option>
                                @foreach ($trips as $trip)
                                  <option value="{{ $trip->trip_id }}">{{ $trip->trip_id }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 text-md-center  align-self-end ">
                            <div class="dropdown">
                                <button class="btn btn-primary w-50 js-filter-trip" type="button"> <span
                                        class="material-symbols-outlined">filter_alt </span> Filter</button>
                            </div>
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
                <a class="btn btn-primary"  style="width: 40px;padding: 0px;" onclick="redirect()" ><i  style="font-size: 21px;" class="bi bi-file-earmark-spreadsheet"></i></a>
                <a class="btn btn-primary mx-2" style="width: 40px;padding: 0px;" onclick="redirects()"><i style="font-size: 21px;" class="bi bi-file-earmark-pdf"></i></a>

            </div> --}}
            <div class="table-responsive">
                <table id="trip-report-table" class="table table-striped table-borderd dc-table"
                    style="border-collapse: collapse!important;">
                    <thead>
                        <tr>
                            <th  style="width:32px;">Sr No</th>
                            <th>Trip ID</th>
                            <th>Rf Id Card Number</th>
                            <th>Event Type</th>
                            <th>Event Date </th>
                            <th>Device ID </th>
                            <th style="width: 200px;">Current Address</th>
                            <th>Latitude </th>
                            <th>Longitude </th>
                            <th>Speed </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script-lib')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>

    <script src="{{ asset('/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
@endpush
@push('style-lib')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <style>
        table thead tr th {
            background-color: #2E3192 !important;
            color: #fff !important;
        }
        #trip-report-table_filter{
            margin-bottom: 10px!important;
        }
        #trip-report-table tr td:nth-child(4), #trip-report-table tr td:nth-child(7) {
            max-width: 200px;
            white-space: inherit;
        }
    </style>
@endpush


@push('script')
    <script>
function redirect() {
            var params = {
                trip_id: $('#trip_id').val(),
              
            };

            var url = "{{ url('admin/reports/excel-lock-unlock-reports') }}";

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
             
            };

            var url = "{{ url('admin/reports/pdf-lock-unlock-reports') }}";

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

        $(document).ready(function() {
            $('.select2').select2();
        });

        $(document).ready(function() {
            var table = $('#trip-report-table').DataTable({
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
                    "url": "{{ route('admin.reports.lock-and-unlock-trips') }}",
                    "type": "POST",
                    'headers': {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    "data": function(d) {
                            d.trip_id = $("#trip_id").val()
                    },
                },
                "ordering": true,
                order: [
                    [1, 'asc']
                ],

            });
            $('[data-toggle="tooltip"]').tooltip();

            $(".js-filter-trip").click(function() {
                const status = $("#trip_report").valid();
                if (status == true) {
                    table.draw();
                }
            });
        });
       
    </script>
@endpush
