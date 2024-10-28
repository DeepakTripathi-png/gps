@extends('admin.layouts.app')
@section('panel') 
        <div class="row">
            <div class="col-xl-12 mx-auto">
                <div class="card">
                    <div class="card-header px-4 py-3 bg-transparent">
                        <h5 class="mb-0">Device Summary Reports</h5>
                    </div>
                    <div class="card-body p-4">
                         <form action="" class="row g-3" method="post" id="device_summary_report" novalidate="novalidate">
                        <div class="col-md-3">
                            <label for="bsValidation4" class="form-label">Device</label>
                            <select id="device_id" class="form-select select2" name="device_id">
                                <option selected value disabled>Select Device</option>
                                @foreach ($gpsdevices as $gpsdevice)
                                    <option value="{{ $gpsdevice->device_id }}">{{ $gpsdevice->device_id }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-md-3">
                            <label for="bsValidation4" class="form-label">Trip ID</label>
                            <select id="trip_id" class="form-select select2" name="trip_id">
                                 <option selected value disabled>Select Trips</option>
                            </select>
                        </div>
                        <div class="col-md-2 text-md-center  align-self-end ">
                            <div class="dropdown">
                                <button class="btn btn-primary w-50 js-filter-trip" type="button" id="device_summary"> <span
                                        class="material-symbols-outlined">filter_alt </span> Filter</button>
                            </div>
                        </div>

                    </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 mx-auto">
                <div class="card" style="border:none;">
                    <div class="card-header px-4 py-3 d-flex justify-content-between align-items-center">
                        {{-- <div class="row"> --}}
                            <h5 class="mb-0 col-auto">Trip Details #<span class="preview" style="color: black;font-weight:600;" id="js-trip_id"></span> </h5>

                            <div class="col-md-6 col-lg-12 d-flex justify-content-end" style="width:auto;">
                                <a class="btn btn-primary" style="width: 45px; padding: 0px; background: transparent; border: 1px solid #4caf50;" onclick="redirect()">
                                    <img width="35" height="35" src="https://img.icons8.com/color/48/ms-excel.png" alt="ms-excel"/>
                                </a>
                                <a class="btn btn-primary mx-2" style="width: 45px; padding: 0px; background: transparent; border: 1px solid #ff5722;" onclick="redirects()">
                                    <img width="26" height="26" style="vertical-align: -webkit-baseline-middle;" src="https://img.icons8.com/color/48/pdf.png" alt="pdf"/>
                                </a>
                            </div>
                        {{-- </div> --}}
                    </div>
                    <div class="card-body p-4">

                        {{-- <div class="col-md-6 col-lg-12" style="display: flex;justify-content: end;">
                            <a class="btn btn-primary" style="width: 40px;padding: 0px;" onclick="redirect()" ><i style="font-size: 21px;" class="bi bi-file-earmark-spreadsheet"></i></a>
                            <a class="btn btn-primary mx-2" style="width: 40px;padding: 0px;" onclick="redirects()" ><i style="font-size: 21px;" class="bi bi-file-earmark-pdf"></i></a>
                        </div> --}}

                        <div class="card mt-2">
                            <div class="card-header px-4 py-2 bg-transparent ">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h6 class="mt-2">Driver Summary</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-12 col-lg-4">
                                      <label for="PhoneNumber" class="form-label">Driver Name:<span class="preview" style="color: black;font-weight:600;" id="js-ds-driver-name"></span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                      <label for="PhoneNumber" class="form-label">Container No:<span class="preview" style="color: black;font-weight:600;" id="js-ds-container-no"></span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                      <label for="Experience3" class="form-label">Vehicle No:<span class="preview" style="color: black;font-weight:600;" id="js-ds-vehicle-no"></span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                      <label for="Experience3" class="form-label">License No:<span class="preview" style="color: black;font-weight:600;" id="js-ds-license-no"></span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                      <label for="Experience2" class="form-label">Id Proof No:<span class="preview" style="color: black;font-weight:600;" id="js-ds-id-proof-no"></span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                       <label for="PhoneNumber" class="form-label">Mobile No: <span class="preview" style="color: black;font-weight:600;" id="js-ds-mobile-no"></span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                      <label for="PhoneNumber" class="form-label">Co Driver Name:<span class="preview" style="color: black;font-weight:600;" id="js-ds-co-dr-na"></span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                       <label for="Experience2" class="form-label">Co Driver License No:<span class="preview" style="color: black;font-weight:600;" id="js-ds-co-dr-li-no"></span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label for="Experience2" class="form-label">Co Drive Id Proof No:<span class="preview" style="color: black;font-weight:600;" id="js-ds-co-dr-id-pr-no"></span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header px-4 py-2 bg-transparent ">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h6  class="mt-2">Trip Summary</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-12 col-lg-4">
                                        <label for="Experience1" class="form-label">Device ID:<span class="preview" style="color: black;font-weight:600;" id="js-ts-device-id"></span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label for="Experience1" class="form-label">Trips ID:<span class="preview" style="color: black;font-weight:600;" id="js-ts-trip-id"></span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label for="Position1" class="form-label">From Destination:<span class="preview" style="color: black;font-weight:600;" id="js-ts-fr-desti"></span> </label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label for="Experience2" class="form-label">To Destination:<span class="preview" style="color: black;font-weight:600;" id="js-ts-to-desti"></span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label for="PhoneNumber" class="form-label">Cargo Type:<span class="preview" style="color: black;font-weight:600;" id="js-ts-cargo-type"></span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label for="PhoneNumber" class="form-label">GST No:<span class="preview" style="color: black;font-weight:600;" id="js-ts-gst-no"></span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label for="PhoneNumber" class="form-label">Start Date:<span class="preview" style="color: black;font-weight:600;" id="js-ts-start-date"></span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label for="PhoneNumber" class="form-label">Expected Date:<span class="preview" style="color: black;font-weight:600;" id="js-ts-expected-date"></span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label for="PhoneNumber" class="form-label">Completed Date:<span class="preview" style="color: black;font-weight:600;" id="js-ts-comp-trip-date"></span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header px-4 py-2 bg-transparent ">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h6  class="mt-2">Shipping Details</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-12 col-lg-4">
                                        <label for="Experience1" class="form-label">Invoice No:<span class="preview" style="color: black;font-weight:600;" id="js-sd-invoice-no"><span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label for="Position1" class="form-label">Invoice Date:<span class="preview" style="color: black;font-weight:600;" id="js-sd-invoice-date"></span> </label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label for="Experience2" class="form-label">Customer CIF INR:<span class="preview" style="color: black;font-weight:600;" id="js-sd-cust-cif-inr"></span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label for="PhoneNumber" class="form-label">E Way Bill No:<span class="preview" style="color: black;font-weight:600;" id="js-sd-e-way-bill-no"></span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label for="PhoneNumber" class="form-label">Shipping Details:<span class="preview" style="color: black;font-weight:600;" id="js-sd-ship-details"></span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label for="PhoneNumber" class="form-label">Exporter Details:<span class="preview" style="color: black;font-weight:600;" id="js-sd-expor-details"></span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label for="PhoneNumber" class="form-label">Start Trip Date:<span class="preview" style="color: black;font-weight:600;" id="js-sd-start-trip-date"></span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label for="PhoneNumber" class="form-label">Expected Arrive Time:<span class="preview" style="color: black;font-weight:600;" id="js-sd-expec-date"></span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                      <label for="PhoneNumber" class="form-label">Cargo Type:<span class="preview" style="color: black;font-weight:600;" id="js-sd-cargo-type"></span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label for="PhoneNumber" class="form-label">Shipment Type:<span class="preview" style="color: black;font-weight:600;" id="js-sd-shipment-type"></span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header px-4 py-2 bg-transparent ">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h6  class="mt-2">Documents</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-12 col-lg-4">
                                        <div class="d-flex align-items-center">
                                            <div class="font-weight-bold text-danger">
                                            <a role="button"  href="javascript:void(0);" download="" data-parent="#accordion" id="down-invoice-bill" style="color: black; font-weight: 600;">
                                                <img class="p-1" data-toggle="tooltip" data-placement="top" title="Invoice Bill"  src="{{asset('assets/icon/download.png')}}" />Invoice Bill
                                            </a>
                                            </div>
                                        </div>   
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <div class="d-flex align-items-center">
                                            <div class="font-weight-bold text-danger">
                                                <a role="button"  href="javascript:void(0);" download="" data-parent="#accordion" id="down-cus-unex-a" style="color: black; font-weight: 600;">
                                                    <img class="p-1" data-toggle="tooltip" data-placement="top" title="Custom Unexture-A"  src="{{asset('assets/icon/download.png')}}" /> Custom Unexture-A
                                                </a>
                                            </div>
                                        </div>   
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <div class="d-flex align-items-center">
                                            <div class="font-weight-bold text-danger">
                                                <a role="button"  href="javascript:void(0);" download="" data-parent="#accordion" id="down-cus-unex-b" style="color: black; font-weight: 600;">
                                                    <img class="p-1" data-toggle="tooltip" data-placement="top" title="Custom Unexture-B"  src="{{asset('assets/icon/download.png')}}"/> Custom Unexture-B
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
            color: #fff!important;
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
            document.addEventListener("DOMContentLoaded", function () {
                var downloadLinks = document.querySelectorAll('[data-parent="#accordion"]');
                downloadLinks.forEach(function (link) {
                    link.setAttribute("disabled", true);
                });
                var shouldEnableDownload = true;
                if (shouldEnableDownload) {
                    downloadLinks.forEach(function (link) {
                        link.removeAttribute("disabled");
                    });
                }
            });
        </script>
        
    <script>
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

            $('[data-toggle="tooltip"]').tooltip();

            $(".js-filter-trip").click(function() {
                const isValid = $("#device_summary_report").valid();
                if (isValid) {
                $.ajax({
                    type: "POST", 
                    url: "{{ route('admin.reports.get-device-summary') }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: $("#device_summary_report").serialize(), 
                    dataType: "json", 
                    success: function (data) {
                        var response =data.device_summary;
                            let tripId = (response.trip_id !== undefined) ? response.trip_id : null;
                            // // Container Details
                            const driverName = (response.container_details.driver_name !== undefined) ? response.container_details.driver_name : null;
                            let containerNo = (response.container_details.container_no !== undefined) ? response.container_details.container_no : null;
                            let vehicleNo = (response.container_details.vehicle_no !== undefined) ? response.container_details.vehicle_no : null;
                            let licenseNo = (response.container_details.license_no !== undefined) ? response.container_details.license_no : null;
                            let idProofNo = (response.container_details.id_proof_no !== undefined) ? response.container_details.id_proof_no : null;
                            let mobileNo = (response.container_details.mobile_no !== undefined) ? response.container_details.mobile_no : null;
                            let coDriverName = (response.container_details.co_driver_name !== undefined) ? response.container_details.co_driver_name : null;
                            let coDriverLicenseNo = (response.container_details.co_driver_license_no !== undefined) ? response.container_details.co_driver_license_no : null;
                            let coDriverIdProofNo = (response.container_details.co_drive_id_proof_no !== undefined) ? response.container_details.co_drive_id_proof_no : null;
                         
                            // Shipping Details
                            let invoiceNo = (response.shipping_details.invoice_no !== undefined) ? response.shipping_details.invoice_no : null;
                            let invoiceDate = (response.shipping_details.invoice_date !== undefined) ? response.shipping_details.invoice_date : null;
                            let customerCifInr = (response.shipping_details.customer_cif_inr !== undefined) ? response.shipping_details.customer_cif_inr : null;
                            let eWayBillNo = (response.shipping_details.e_way_bill_no !== undefined) ? response.shipping_details.e_way_bill_no : null;
                            let shippingDetails = (response.shipping_details.shipping_details !== undefined) ? response.shipping_details.shipping_details : null;
                            let exporterDetails = (response.shipping_details.exporter_details !== undefined) ? response.shipping_details.exporter_details : null;
                            let cargoType = (response.shipping_details.cargo_type !== undefined) ? response.shipping_details.cargo_type : null;
                            let shipmentType = (response.shipping_details.shipment_type !== undefined) ? response.shipping_details.shipment_type : null;

                            let tripStartDate = (response.trip_start_date !== undefined) ? response.trip_start_date : null;
                            let expectedArrivalTime = (response.expected_arrival_time !== undefined) ? response.expected_arrival_time : null;
                            let completedTripTime = (response.completed_trip_time !== undefined) ? response.completed_trip_time : null;

                            let invoiceBillurl = (response.invoice_bill_url !== undefined) ? response.invoice_bill_url : null;
                            let customUnextureAurl = (response.custom_unexture_A_url !== undefined) ? response.custom_unexture_A_url : null;
                            let customUnextureBurl = (response.custom_unexture_B_url !== undefined) ? response.custom_unexture_B_url : null;
                          
                            let gstno = (response.gstno !== undefined) ? response.gstno : null;
                            let fromLocationName = (response.from_location_name !== undefined) ? response.from_location_name : null;
                            let toLocationName = (response.to_location_name !== undefined) ? response.to_location_name : null;
                            let deviceId = (response.device_id !== undefined) ? response.device_id : null;
                            $('#js-trip_id').text(tripId);

                            //Container Details
                            $('#js-ds-driver-name').text(driverName);
                            $('#js-ds-container-no').text(containerNo);
                            $('#js-ds-vehicle-no').text(vehicleNo);
                            $('#js-ds-license-no').text(licenseNo);
                            $('#js-ds-id-proof-no').text(idProofNo);
                            $('#js-ds-mobile-no').text(mobileNo);
                            $('#js-ds-co-dr-na').text(coDriverName);
                            $('#js-ds-co-dr-li-no').text(coDriverLicenseNo);
                            $('#js-ds-co-dr-id-pr-no').text(coDriverIdProofNo);

                            // Trip Summary
                            $('#js-ts-device-id').text(deviceId);
                            $('#js-ts-trip-id').text(tripId);
                            $('#js-ts-fr-desti').text(fromLocationName);
                            $('#js-ts-to-desti').text(toLocationName);
                            $('#js-ts-cargo-type').text(cargoType);
                            $('#js-ts-gst-no').text(gstno);
                            $('#js-ts-start-date').text(tripStartDate);
                            $('#js-ts-expected-date').text(expectedArrivalTime);
                            $('#js-ts-shipment-type').text(completedTripTime);

                           // Shipping Details
                            $('#js-sd-invoice-no').text(invoiceNo);
                            $('#js-sd-invoice-date').text(invoiceDate);
                            $('#js-sd-cust-cif-inr').text(customerCifInr);
                            $('#js-sd-e-way-bill-no').text(eWayBillNo);
                            $('#js-sd-ship-details').text(shippingDetails);
                            $('#js-sd-expor-details').text(exporterDetails);
                            $('#js-sd-start-trip-date').text(tripStartDate);
                            $('#js-sd-expec-date').text(expectedArrivalTime);
                            $('#js-sd-cargo-type').text(cargoType);
                            $('#js-sd-shipment-type').text(shipmentType);

                            $('#down-invoice-bill').attr("href", invoiceBillurl)
                            $('#down-cus-unex-a').attr("href", customUnextureAurl)
                            $('#down-cus-unex-b').attr("href", customUnextureBurl)
                    },
                  
                });
            } else {
                console.log("Form is not valid");
            }
            });
        });


        function redirect() {
            var params = {
                device_id: $('#device_id').val(),
                trip_id: $('#trip_id').val(),
            };

            var url = "{{ url('admin/reports/excel-device-summary-reports') }}";

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
            var device_id = $('#device_id').val();
            var trip_id = $('#trip_id').val();
            if (device_id !== null && trip_id !== null) {
            var params = {
                device_id: device_id,
                trip_id: trip_id
            };
            } else {
                
            }

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
                var ajaxDiv = $('#trip_id');
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
