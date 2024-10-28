@extends('admin.layouts.app')
@section('panel')
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-xl-6 row-cols-xxl-6">
        <div class="col">
            <div class="card radius-10 border-0 border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="">
                            <p class="mb-1">Total Customers</p>
                            <h4 class="mb-0 text-primary">{{ $totalcustomer }}</h4>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 4.5px;">
                        <div class="progress-bar" role="progressbar" style="width: {{ $totalcustomer }}%;"
                            aria-valuenow="{{ $totalcustomer }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col">
            <div class="card radius-10 border-0 border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="">
                            <p class="mb-1">Total Port Users</p>
                            <h4 class="mb-0 text-primary">{{ $totalusers??''}}</h4>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 4.5px;">
                        <div class="progress-bar" role="progressbar" style="width: {{ $totalusers??'' }}%;"
                            aria-valuenow="{{ $totalusers ??''}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col">
            <div class="card radius-10 border-0 border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="">
                            <p class="mb-1">Mapped Device</p>
                            <h4 class="mb-0 text-success">{{ $mappeddevicecount }}</h4>
                        </div>

                    </div>
                    <div class="progress mt-3" style="height: 4.5px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $mappeddevicecount }}%;"
                            aria-valuenow="{{ $mappeddevicecount }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-0 border-start border-danger border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="">
                            <p class="mb-1">Available Device</p>
                            <h4 class="mb-0 text-danger">{{ $availabledevice }}</h4>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 4.5px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $availabledevice }}%;"
                            aria-valuenow="{{ $availabledevice }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-0 border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="">
                            <p class="mb-1">Total Trips</p>
                            <h4 class="mb-0 text-primary">{{ $totaltripcount }}</h4>
                        </div>

                    </div>
                    <div class="progress mt-3" style="height: 4.5px;">
                        <div class="progress-bar" role="progressbar" style="width: {{ $totaltripcount }}%;"
                            aria-valuenow="{{ $totaltripcount }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-0 border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="">
                            <p class="mb-1">Ongoing Trips</p>
                            <h4 class="mb-0 text-success">{{ $totalongoingtrip }}</h4>
                        </div>

                    </div>
                    <div class="progress mt-3" style="height: 4.5px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $totalongoingtrip }}%;"
                            aria-valuenow="{{ $totalongoingtrip }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-0 border-start border-danger border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="">
                            <p class="mb-1">Completed Trips</p>
                            <h4 class="mb-0 text-danger">{{ $totalcompletedtrip }}</h4>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 4.5px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $totalcompletedtrip }}%;"
                            aria-valuenow="{{ $totalcompletedtrip }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="card">
                <div class="card-header bg-transparent py-3">
                    <h6 class="text-uppercase mb-0"><span class="text-success">Online </span>/<span
                            class="text-danger">Offline </span> Vehicles</h6>
                </div>
                <div class="card-body">
                    <div id="marker-map" class="gmaps"></div>
                </div>
            </div>
        </div>
    </div>
    
    <!--end row-->
    <div class="row">
        <div class="col-12 col-lg-6 col-xl-6 d-flex">
            <div class="card w-100">
                <div class="card-header bg-transparent">
                    <div class="d-flex align-items-center">
                        <div class="">
                            <h6 class="mb-0 fw-bold">Events/Alerts</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive white-space-nowrap">
                        <table id="events" class="table text-center">
                            <thead>
                                <tr>
                                    <th></th>
                                    {{-- <th></th> --}}
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 mx-auto">
            <h6 class="mb-0 text-uppercase">Pie Chart</h6>
            <hr>
            <div class="card">
                <div class="card-body">
                    <div id="chart8"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-transparent">
            <div class="d-flex align-items-center">
                <h5 class="mb-2 fw-bold">Recent Added Trips</h5>
            </div>
        </div>
        <div class=" card-body customer-table">
            <div class="table-responsive white-space-nowrap">
                <table id="example2" class="table text-center">
                    <thead>
                        <tr>
                            <th>Trip Id</th>
                            <th>From Location</th>
                            <th>To Location</th>
                            <th>Current Location</th>
                            <th>Start Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row d-none ">
        <div class="col-xl-12 mx-auto">
            <div class="card">
                <div class="card-header bg-transparent py-3">
                    <h6 class="text-uppercase mb-0">Simple Basic Map</h6>
                </div>
                <div class="card-body">
                    <div id="simple-map" class="gmaps"></div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-transparent py-3">
                    <h6 class="text-uppercase mb-0">Map With Marker</h6>
                </div>
                <div class="card-body">
                    <div id="marker-map" class="gmaps"></div>
                    <div id="svg-container">
                        <img id="marker-image" src="" alt="Marker" />
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('script-lib')
<script>
    var map;
    var imagePathGreen = "https://gpspackseal.in/assets/icon/vehical_green.svg";
    var imagePathRed = "https://gpspackseal.in/assets/icon/vehical_red.svg";
    var imagePathOrange = "https://gpspackseal.in/assets/icon/vehical_orange.svg";

    var markers = [];
    var mapMarkers = [];
    function initMap() {
        
        var myLatLng = {
            lat: 18.477212,
            lng: 73.960032
        };

        map = new google.maps.Map(document.getElementById('marker-map'), {
            zoom: 8,
            center: myLatLng
        });


        updateMarkers();

        setInterval(updateMarkers, 15000);
    }

    function updateMarkers() {
        $.ajax({
            type: "POST",
            url: "{{ route('admin.live-location') }}",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            data: {},
            dataType: "JSON",
            success: function(response) {
                const deviceData = response['device_data'];

                markers = [];

                // Iterate through the deviceData and push marker information into the markers array
                deviceData.forEach(function(markerInfo) {
                    markers.push({
                        position: {
                            lat: parseFloat(markerInfo.position.lat),
                            lng: parseFloat(markerInfo.position.lng)
                        },
                        // title: markerInfo.title,
                        info: markerInfo.info,
                        device_id: markerInfo.device_id,
                        vehicle_no: markerInfo.vehicle_no,
                        expected_arrival_time: markerInfo.expected_arrival_time,
                        trip_start_date: markerInfo.trip_start_date,
                        address: markerInfo.address,
                        trip_id: markerInfo.trip_id,
                        assign_trip_id: markerInfo.assign_trip_id,
                        device_status: markerInfo.device_status,
                        lastupdate: markerInfo.lastupdate,
                        lock: markerInfo.lock,

                    });
                });

                // After updating markers, recreate the map markers
                createMapMarkers();
            },
        });
    }

    // Function to create map markers based on the markers array
    function createMapMarkers() {

        clearMarkers();

        markers.forEach(function(marker) {

            var color = '';
            var imagePath = '';
            //  marker.device_status='idle';
            if (marker.device_status == 'online') {
                color = 'green';
                imagePath = imagePathGreen;
            } else if (marker.device_status == 'offline') {
                color = 'red';
                imagePath = imagePathRed;
            } else if (marker.device_status == 'idle') {
                color = 'orange';
                imagePath = imagePathOrange;
            } else {
                color = 'red';
                imagePath = imagePathRed;
            }

            let statusText;
            var colorLock = '';
            if (marker.lock == 'lock') {
                statusText = 'Lock';
                colorLock = 'green';
            } else {
                statusText = 'Unlock';
                colorLock = 'red';
            }

            var markerObj = new google.maps.Marker({
                position: marker.position,
                map: map,
                title: marker.title,
                icon: imagePath,
            });

            mapMarkers.push(markerObj);

            // console.log(marker.assign_trip_id);

            // Info window content for each marker
            const id = marker.assign_trip_id;
            // console.log(id);

            if(marker.trip_id!='' && marker.trip_id) {
                var url = '{{ route('admin.device.live-tracking', ':id') }}';
                url = url.replace(':id', id);
            } else {
                url ="#";
            }
           

            //  console.log(url);
            var contentString = `<div class="" id="tripDetailsModal" tabindex="-1" role="dialog" aria-labelledby="tripDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 270px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" style="margin-bottom: -10px;">TRIP DETAILS </h6>
                    <a href="${url}" class="float-right">TRIP ID : ${marker.trip_id}</a>
                </div>
                <div class="modal-body">
                    <hr>
                    <p class="mb-2"><strong>Device No:</strong> ${marker.device_id}</p>
                    <p class="mb-2"><strong>Vehicle No:</strong> ${marker.vehicle_no}</p>
                    <p class="mb-2"><strong>Lock Status:</strong> <span class="${colorLock}">${statusText} </span></p>
                    <p class="mb-2"><strong>Last Location Update at:</strong> ${marker.lastupdate}</p>
                    <p class="mb-2"><strong>Status:</strong> <span class="${color}">${marker.device_status} </span> </p>
                    <p class="mb-2"><strong>Start Date:</strong>${marker.trip_start_date}</p>
                    <p class="mb-2"><strong>Expected Date:</strong> ${marker.expected_arrival_time}</p>
                    <p class="mb-2"><strong>Current Location:</strong> ${marker.address} </p>
                </div>
            </div>
        </div>
    </div>
    `;
            var infoWindow = new google.maps.InfoWindow({
                content: contentString
            });
            // Open the info window when the marker is clicked
            markerObj.addListener('click', function() {
                infoWindow.open(map, markerObj);
            });
        });
    }

    // Function to clear existing markers from the map
    function clearMarkers() {
        for (var i = 0; i < mapMarkers.length; i++) {
            mapMarkers[i].setMap(null);
        }
        mapMarkers = [];
    }
   
</script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvNFKRBGD7GiXGArCB8wXu-fnrXHIFYoc&amp;callback=initMap">
    </script>
    
    <script src="{{ asset('/assets/plugins/easyPieChart/jquery.easypiechart.js') }}"></script>
    <script src="{{ asset('/assets/plugins/apex/apexcharts.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/apex/apex-custom.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  
@endpush
@push('style-lib')
    <style>
        .gmaps {
            height: 600px;
        }

        table thead tr th {
            background-color: #2E3192 !important;
            color: #fff !important;
            font-size: 10px;
        }

        #events thead tr {
            display: none;
        }

        #events_filter {
            display: none;
        }

        .green {
            color: green;
            font-weight: 600;
        }

        .red {
            color: red;
            font-weight: 600;
        }

        .orange {
            color: orange;
            font-weight: 600;
        }


        /* #events td{
                border-left: 4px solid red;
            } */
    </style>
@endpush
@push('script')
    <script>
        $(document).ready(function() {
            var table = $('#example2').DataTable({
                "dom": 'frtip',
                "paging": true,
                "iDisplayLength": 5,
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ route('admin.dashboard-added-trips') }}",
                    "type": "POST",
                    'headers': {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                },
                "ordering": true,
                order: [
                    [1, 'asc']
                ],

            });
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#events').DataTable({
                "dom": 'frtip',
                "paging": true,
                "iDisplayLength": 4,
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ route('admin.dashboard-event-alert') }}",
                    "type": "POST",
                    'headers': {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                },
                createdRow: function(row, data, dataIndex) {
                    $('tr td:eq(1)', row).attr('colspan', 2);
                }


            });
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
   
@endpush
