@extends('admin.layouts.app')
@section('panel') 
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="card">
                <div class="card-header px-4 py-3 bg-transparent">
                    <h5 class="mb-0">Replay Reports</h5>
                </div>

                <div class="card-body p-4">
                    <form class="row g-3" method="post" id="trip_report" novalidate="novalidate">
                        <div class="col-md-3">
                            <label class="form-label">Trip ID </label>
                            <select class="form-select select2" name="trip_id" id="trip_id" >
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
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- <div class="card">
        <div class="card-header px-4 py-3 bg-transparent">
            <h5 class="mb-0">Trips</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example2" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Trip ID</th>
                            <th>Cargo Type</th>
                            <th>Shipment Type</th>
                            <th>Location</th>
                            <th>Driver name</th>
                            <th>Vehicle No</th>
                            <th>Contact No</th>
                            <th>Start Date</th>
                            <th>Exp Date</th>
                            <th>Events</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>DFG345267</td>
                        <td>By Road</td>
                        <td>Domestic</td>
                        <td>Bangladesh - India</td>
                        <td>Sanket</td>
                        <td>MH01GH4561</td>
                        <td>8845698712</td>
                        <td>2023-10-08</td>
                        <td>2023-12-25</td>
                        <td>Lock,Motor Stuck</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>DFG345267</td>
                        <td>Railway</td>
                        <td>Domestic</td>
                        <td>Bangladesh - India</td>
                        <td>Sanket</td>
                        <td>MH01GH4561</td>
                        <td>8845698712</td>
                        <td>2023-10-08</td>
                        <td>2023-12-25</td>
                        <td>Low Battery,Motor Stuck</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-xl-12 mx-auto trip-replay-route">
            <div class="card">
                <div class="card-header bg-transparent py-3">
                    <h6 class="text-uppercase mb-0">Replay Trips</h6>
                </div>
                <div class="card-body">
                    <div id="marker-map" class="gmaps" style="height: 600px;"></div>
                </div>
            </div>
        </div>
    </div>
  @endsection

@push('script-lib')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>

    <script src="{{ asset("/assets/plugins/datatable/js/jquery.dataTables.min.js") }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvNFKRBGD7GiXGArCB8wXu-fnrXHIFYoc&amp;&libraries=geometry,directions"></script> 
@endpush

@push('style-lib')
    <link href="{{ asset("/assets/flatpickr/dist/flatpickr.min.css") }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<style>
    table thead tr th {
    background-color: #2E3192 !important;
    color: #fff!important;
    }

</style>
@endpush

  @push('script')

   <script>
    var imagePathGreen = "https://gpspackseal.in/assets/icon/vehical_green.svg";
    $(document).ready(function() {
        // var table = $('#example2').DataTable({
        //     lengthChange: false,
        //     "ordering": false,
        //     buttons: [ 'copy', 'excel', 'pdf', 'print'],
        // });
        // table.buttons().container().appendTo( '#example2_wrapper .col-md-6:eq(0)');
        // $('[data-toggle="tooltip"]').tooltip();
        $('.select2').select2();
    });

    var coordinates; 

    var myLatLng = {
        lat: 18.477212,
        lng: 73.960032
    };

    map = new google.maps.Map(document.getElementById('marker-map'), {
        zoom: 8,
        center: myLatLng
    });

    $(".js-filter-trip").click(function() {
        console.log('f');
        const tripId = $("#trip_id").val();
        $.ajax({
            type: 'POST',
            url: "{{ route('admin.reports.get-replay-trips') }}",
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            data: {
                trip_id: tripId
            },
            // dataType: "JSON",
            success: function(data) {
                const response = JSON.parse(data);
                coordinates = response.trip_complete_data;
                if(coordinates.length > 0) {
                    
                    var centerLat = 0;
                    var centerLng = 0;
                    var vehicleMarker;
                    var bounds = new google.maps.LatLngBounds();
                    var snappedCoordinates = [];
                    var moveDelay = 5000; // 5 seconds delay
                    var infoWindow;
                    function initMap() {
                    map = new google.maps.Map(document.getElementById('marker-map'), {
                        center: bounds.getCenter(),
                        zoom: 16
                    });

                    var service = new google.maps.DirectionsService();

                    service.route({
                        origin: coordinates[0],
                        destination: coordinates[coordinates.length - 1],
                        travelMode: google.maps.TravelMode.DRIVING
                    }, function (result, status) {
                        if (status === google.maps.DirectionsStatus.OK) {
                            var path = result.routes[0].overview_path;
                            snappedCoordinates = path.map(function (location) {
                                bounds.extend(location);
                                // console.log(bounds);
                                return { lat: location.lat(), lng: location.lng() };
                            });

                            var flightPath = new google.maps.Polyline({
                                path: snappedCoordinates,
                                geodesic: true,
                                strokeColor: "#2E3192",
                                strokeOpacity: 1.0,
                                strokeWeight: 4,
                            });

                            // Add marker for "from location"
                            vehicleMarker = new google.maps.Marker({
                                position: snappedCoordinates[0],
                                map: map,
                                icon: imagePathGreen,
                                // label: 'From'
                            });


                            // infoWindow = new google.maps.InfoWindow({
                            //     content: info
                            // });
                                
                            // vehicleMarker.addListener('click', function () {
                            //     infoWindow.open(map, vehicleMarker);
                            // });

                            // Add marker for "to location"
                            var toLocation = new google.maps.Marker({
                                position: snappedCoordinates[snappedCoordinates.length - 1],
                                map: map,
                                label: 'To'
                            });

                            flightPath.setMap(map);
                            map.fitBounds(bounds);
                        } else {
                            console.error('Directions request failed due to ' + status);
                        }
                    });

                    setTimeout(moveVehicle, moveDelay);
                    }

                    function moveVehicle() {
                        var index = 0;
                        var moveStartTime = performance.now();
                    
                        function animate() {
                            var now = performance.now();
                            var elapsed = now - moveStartTime;
                            var duration = 3000; // Set a fixed duration for the animation in milliseconds (adjust as needed)
                            var progress = elapsed / duration;
                        
                            if (progress <= 1) {
                                var indexFractional = index + progress;
                                var newPosition = snappedCoordinates[Math.floor(indexFractional)];
                                var nextPosition = snappedCoordinates[Math.ceil(indexFractional)] || newPosition;
                        
                                // Interpolate between positions for smoother movement
                                var lat = newPosition.lat + (nextPosition.lat - newPosition.lat) * (indexFractional % 1);
                                var lng = newPosition.lng + (nextPosition.lng - newPosition.lng) * (indexFractional % 1);
                        
                                var newPositionInterpolated = { lat: lat, lng: lng };
                        
                                // Calculate the rotation angle
                                var heading = google.maps.geometry.spherical.computeHeading(vehicleMarker.getPosition(), newPositionInterpolated);
                                rotateMarker(heading);
                        
                                // Update marker position and rotation
                                vehicleMarker.setPosition(newPositionInterpolated);
                                vehicleMarker.setIcon({
                                    url: imagePathGreen,
                                    scaledSize: new google.maps.Size(44, 44),
                                    origin: new google.maps.Point(0, 0),
                                    anchor: new google.maps.Point(24, 24),
                                    rotation: heading,
                                });

                                // info ="fsdf";
                        
                                // Update the content of the info window with the new information
                                //infoWindow.setContent(info);
                                // infoWindow.open(map, vehicleMarker);
                        
                                requestAnimationFrame(animate);
                            } else {
                                // Move to the next index when the animation is complete
                                index++;
                                moveStartTime = now;
                                requestAnimationFrame(animate);
                            }
                        }
                        animate();
                    }
                    
                    initMap();

                    function rotateMarker(degree) {
                        $('img[src="https://gpspackseal.in/assets/icon/vehical_green.svg"]').css({
                            'transform': 'rotate(' + degree + 'deg)'
                        });
                    }

                } else {
                    notify('error', 'Trip data not found');
                }
               
            // const ajaxDiv = $('#alert_trip');
            // var html ='';
            // for (let i = 0; i < data.length; i++) {
            //     const element = data[i];
            //     html += `
            //             <div class="col-12 mx-auto py-2">
            //                 <div class="card radius-15 border-0">
            //                     <div class="card-body">
            //                         <div>
            //                             <div class="text-left fw-bold" style="width: 100%;
            //                                 text-align: left;
            //                                 border-bottom: 1px solid #e9edf3;
            //                                 line-height: 0.1em;
            //                                 margin: 10px auto 15px;">
            //                                 <span style="background: #fff;
            //                                     padding: 0 10px;">${element.alert_title}</span>
            //                             </div>
            //                             <div class="w-10 mx-auto "><span style="font-size:13px;">Address: ${element.address}</span></div>
            //                             <div class="w-10 mx-auto "><span style="font-size:13px;">Date:${element.date} </span> <label style="font-size:12px;margin-top:-15px" class="d-flex justify-content-end">RF ID:${element.rf_card_number}</label></div>
            //                         </div>
            //                     </div>
            //                 </div>
            //             </div>`;
            // }
            // ajaxDiv.html(html);
            }
        });
    });

        

	</script>
  
   @endpush

  </body>

</html>