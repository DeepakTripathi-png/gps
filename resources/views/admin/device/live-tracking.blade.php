@extends('admin.layouts.app')
@section('panel')
{{-- <div class="card">
    <div class="card-body">
        <div class="d-flex flex-lg-row flex-column align-items-start align-items-lg-center justify-content-between gap-3">
            <div class="flex-grow-1">
                <h4 class="fw-bold">{{$pageTitle}}</h4>
            </div>
        </div>
    </div>
</div> --}}

      <div class="row">

            <div class="col-12 col-lg-4 col-xxl-4  d-flex">
                <div class="card w-100 mb-0">
                    <div class="card-body p-0">
                        <div class="row">
                                <div class="col-lg-12 mx-auto">
                                  <div class="tab-content " style="height: calc(85vh - 42px);overflow:auto;background: #e5efff;">
                                    <form id="" method="post">
                                        <input type="hidden" name="trip_id" id="tripId" value="{{ $id }}">
                                        @csrf
                                    </form>
                                      <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
                                        <div class="card-body" style="background:#ffffff;">
                                            <p class="fw-bold d-flex justify-content-between">
                                                <label class="float-right"> Trip ID : {{ $trip_details['trip_id'] ?? '' }}</label>
                                                <label class="{{ 
                                                    $trip_details['device_status'] == 'offline' ? 'text-danger' : 
                                                    ($trip_details['device_status'] == 'idle' ? 'text-warning' : 'text-success') 
                                                }}"> {{ Str::ucfirst($trip_details['device_status']) ?? '' }}</label>
                                            </p>
                                            
                                            <p class="fw-bold d-flex justify-content-between ">
                                                <label class="float-right">From Location : {{ $trip_details['from_location_name']?? '' }}</label>
                                                <label class="text-muted">  — To — </label>
                                                <label class="float-right">Location: {{$trip_details['to_location_name'] ?? ''}}</label>
                                            </p>

                                            <p class="fw-bold d-flex justify-content-between">
                                                <label class="float-right">Start Date : {{ date('d-m-Y H:i:s A', strtotime($trip_details['start_trip_date'])) }}</label>
                                                <label class="text-muted">  — To — </label>
                                                <label class="float-right">Expected Date:{{ date('d-m-Y H:i:s A', strtotime($trip_details['expected_arrive_time'])) }}</label>
                                            </p>
                                            <p class="fw-bold text-danger ">Battery :{{ $trip_details['battery'] ?? ''}}%</p>
                                        </div>
                                        

                                        <div class="card-body">
                                            <div class="container py-2">
                                                <div class="row">
                                                    <div class="col-auto text-center flex-column d-none d-sm-flex">
                                                        <h5 class="m-0 ">
                                                            <span class="badge rounded-pill  border bg-success">&nbsp;</span>
                                                        </h5>
                                                      <div class="row h-100">
                                                            <div class="col border-2 border-end border-success">&nbsp;</div>
                                                            <div class="col">&nbsp;</div>
                                                        </div>
                                                      
                                                    </div>
                                                    <div class="col-10 mx-auto  py-2">
                                                            <div class="card radius-15 border-0">
                                                                <div class="card-body ">
                                                                    <div>
                                                                        <div class="text-center fw-bold" style="width: 100%;
                                                                            text-align: center;
                                                                            border-bottom: 1px solid #e9edf3;
                                                                            line-height: 0.1em;
                                                                            margin: 10px auto 15px;"><span style="background: #fff;
                                                                            padding: 0 10px;"> <img style="padding-bottom: 5px;margin-right: 5px;" src="{{asset('assets/icon/location-green.png')}}" />Start Address</span></div>
                                                                        <div class="w-10 mx-auto ">{{ $trip_details['start_address'] ?? '' }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-auto text-center flex-column d-none d-sm-flex">
                                                        <div class="row h-50">
                                                            <div class="col border-2 border-end border-success">&nbsp;</div>
                                                            <div class="col">&nbsp;</div>
                                                        </div> 
                                                         <!-- <h5 class="m-0 ">
                                                            <span class="badge rounded-pill  border bg-success">&nbsp;</span>
                                                        </h5>  -->
                                                        <div class="row h-50">
                                                            <div class="col border-2 border-end border-success">&nbsp;</div>
                                                            <div class="col">&nbsp;</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-10 mx-auto  py-2">
                                                            <div class="card radius-15 border-0" style="background-color: transparent;">
                                                                <div class="card-body ">
                                                                    <div>
                                                                        <p class="mb-1  d-flex justify-content-between">
                                                                            <label class="float-right"><img width="27" class="p-1" src="{{asset('assets/icon/live-tracking.png')}}" /> Distance Covered:</label>
                                                                            <label class="text-muted"> 1035 Km</label>
                                                                        </p>

                                                                        <p class="mb-1  d-flex justify-content-between">
                                                                          <label class="float-right"><img width="25" class="p-1"  src="{{asset('assets/icon/speedometer.png')}}" /> Maximum Speed: </label>                                                                                 
                                                                          <label class="text-muted"> 75 Km/h  </label>                                                                              
                                                                        </p>

                                                                        <p class="mb-1 d-flex justify-content-between">
                                                                            <label class="float-right"><img width="25" class="p-1"  src="{{asset('assets/icon/speedometer.png')}}" /> Average Speed:</label>
                                                                            <label class="text-muted"> 30.50Km/h  </label>                                                                              
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                             

                                                <div class="row">

                                                  <div class="col-auto text-center flex-column d-none d-sm-flex">
                                                      <div class="row h-50">
                                                          <div class="col border-2 border-end border-success">&nbsp;</div>
                                                          <div class="col">&nbsp;</div>
                                                      </div> 
                                                       
                                                      <div class="row h-50">
                                                          <div class="col border-2 border-end border-success">&nbsp;</div>
                                                          <div class="col">&nbsp;</div>
                                                      </div>
                                                      <h5 class="m-0 ">
                                                        <span class="badge rounded-pill  border bg-success">&nbsp;</span>
                                                    </h5>
                                                  </div>
                                                    

                                                    <div class="col-10 mx-auto  py-2">
                                                            <div class="card radius-15 border-0">
                                                                <div class="card-body ">
                                                                    <div>
                                                                        <div class="text-center fw-bold" style="width: 100%;
                                                                            text-align: center;
                                                                            border-bottom: 1px solid #e9edf3;
                                                                            line-height: 0.1em;
                                                                            margin: 10px auto 15px;"><span style="background: #fff;
                                                                            padding: 0 10px;">
                                                                            <img style="padding-bottom: 5px;margin-right: 5px;"  src="{{asset('assets/icon/location-orange.png')}}" /> {{ $trip_details['trip_status'] == 'assign' ? 'Current' : 'End' }} Address</span></div>
                                                                        <div class="w-10 mx-auto "> {{ $trip_details['address'] ?? '' }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      </div>
                                  

                                    <div class="tab-pane fade" id="stops" role="tabpanel">
                                      <div class="card-body" style="background:#e5efff">
                                          <div class="container py-2">

                                              <div class="row">

                                                  <div class="col-12 mx-auto  py-2">
                                                          <div class="card radius-15 border-0">
                                                              <div class="card-body ">
                                                                  <div>
                                                                      <div class="text-center fw-bold" style="width: 100%;
                                                                          text-align: center;
                                                                          border-bottom: 1px solid #e9edf3;
                                                                          line-height: 0.1em;
                                                                          margin: 10px auto 15px;"><span style="background: #fff;
                                                                          padding: 0 10px;"><img style="padding-bottom: 5px;margin-right: 5px;"  src="{{asset('assets/icon/location-orange.png')}}" />Stop Address</span></div>
                                                                      <div class="w-10 mx-auto ">SH58, Alandi, Khed, Pune, Maharashtra, 412105, India, SH58, Alandi, Pune, Maharashtra, IN, 412105
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>

                                                  <div class="col-12 mx-auto  py-2">
                                                    <div class="card radius-15 border-0">
                                                        <div class="card-body ">
                                                            <div>
                                                                <div class="text-center fw-bold" style="width: 100%;
                                                                    text-align: center;
                                                                    border-bottom: 1px solid #e9edf3;
                                                                    line-height: 0.1em;
                                                                    margin: 10px auto 15px;"><span style="background: #fff;
                                                                    padding: 0 10px;"><img style="padding-bottom: 5px;margin-right: 5px;"  src="{{asset('assets/icon/location-orange.png')}}" />Stop Address</span></div>
                                                                <div class="w-10 mx-auto ">SH58, Alandi, Khed, Pune, Maharashtra, 412105, India, SH58, Alandi, Pune, Maharashtra, IN, 412105
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12 mx-auto  py-2">
                                              <div class="card radius-15 border-0">
                                                  <div class="card-body ">
                                                      <div>
                                                          <div class="text-center fw-bold" style="width: 100%;
                                                              text-align: center;
                                                              border-bottom: 1px solid #e9edf3;
                                                              line-height: 0.1em;
                                                              margin: 10px auto 15px;"><span style="background: #fff;
                                                              padding: 0 10px;"><img style="padding-bottom: 5px;margin-right: 5px;"  src="{{asset('assets/icon/location-orange.png')}}" />Stop Address</span></div>
                                                          <div class="w-10 mx-auto ">SH58, Alandi, Khed, Pune, Maharashtra, 412105, India, SH58, Alandi, Pune, Maharashtra, IN, 412105
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>


                                            <div class="col-12 mx-auto  py-2">
                                              <div class="card radius-15 border-0">
                                                  <div class="card-body ">
                                                      <div>
                                                          <div class="text-center fw-bold" style="width: 100%;
                                                              text-align: center;
                                                              border-bottom: 1px solid #e9edf3;
                                                              line-height: 0.1em;
                                                              margin: 10px auto 15px;"><span style="background: #fff;
                                                              padding: 0 10px;"><img style="padding-bottom: 5px;margin-right: 5px;"  src="{{asset('assets/icon/location-orange.png')}}" />Stop Address</span></div>
                                                          <div class="w-10 mx-auto ">SH58, Alandi, Khed, Pune, Maharashtra, 412105, India, SH58, Alandi, Pune, Maharashtra, IN, 412105
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="alerts" role="tabpanel">
                            <div class="card-body" style="background:#e5efff">
                                <div class="container py-2">
                                    <div class="row" id="alert_trip">
                                   
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="replay" role="tabpanel">

                            <div class="card-body" style="background:#ffffff;">
                                <p class="fw-bold d-flex justify-content-between">
                                    <label class="float-right"> Trip ID :456587888</label>
                                    <label class="text-success"> Online</label>
                                </p>
                            </div>
                            

                            <div class="card-body" style="background:#e5efff">
                                <div class="container py-2">
                                    <div class="row">
                                        <div class="col-auto text-center flex-column d-none d-sm-flex">
                                            <h5 class="m-0 ">
                                                <span class="badge rounded-pill  border bg-success">&nbsp;</span>
                                            </h5>
                                        <div class="row h-100">
                                                <div class="col border-2 border-end border-success">&nbsp;</div>
                                                <div class="col">&nbsp;</div>
                                            </div>
                                        
                                        </div>
                                        <div class="col-10 mx-auto  py-2">
                                                <div class="card radius-15 border-0">
                                                    <div class="card-body ">
                                                        <div>
                                                            <div class="text-center fw-bold" style="width: 100%;
                                                                text-align: center;
                                                                border-bottom: 1px solid #e9edf3;
                                                                line-height: 0.1em;
                                                                margin: 10px auto 15px;"><span style="background: #fff;
                                                                padding: 0 10px;"> <img style="padding-bottom: 5px;margin-right: 5px;" src="{{asset('assets/icon/location-green.png')}}" />Start Address</span></div>
                                                            <div class="w-10 mx-auto ">Chande, Mulshi, Pune, Maharashtra, 411057, India, Chande, Pune, Maharashtra, IN, 411057
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-auto text-center flex-column d-none d-sm-flex">
                                            <div class="row h-50">
                                                <div class="col border-2 border-end border-success">&nbsp;</div>
                                                <div class="col">&nbsp;</div>
                                            </div> 
                                            <div class="row h-50">
                                                <div class="col border-2 border-end border-success">&nbsp;</div>
                                                <div class="col">&nbsp;</div>
                                            </div>
                                        </div>
                                        <div class="col-10 mx-auto  py-2">
                                                <div class="card radius-15 border-0" style="background-color: transparent;">
                                                    <div class="card-body ">
                                                        <div>
                                                            <p class="mb-1  d-flex justify-content-between">
                                                                <label class="float-right"><img width="27" class="p-1" src="{{asset('assets/icon/live-tracking.png')}}" /> Distance Covered:</label>
                                                                <label class="text-muted"> 1035 Km</label>
                                                            </p>

                                                            <p class="mb-1  d-flex justify-content-between">
                                                            <label class="float-right"><img width="25" class="p-1"  src="{{asset('assets/icon/speedometer.png')}}" /> Maximum Speed: </label>                                                                                 
                                                            <label class="text-muted"> 75 Km/h  </label>                                                                              
                                                            </p>

                                                            <p class="mb-1 d-flex justify-content-between">
                                                                <label class="float-right"><img width="25" class="p-1"  src="{{asset('assets/icon/speedometer.png')}}" /> Average Speed:</label>
                                                                <label class="text-muted"> 30.50Km/h  </label>                                                                              
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                

                                    <div class="row">

                                    <div class="col-auto text-center flex-column d-none d-sm-flex">
                                        <div class="row h-50">
                                            <div class="col border-2 border-end border-success">&nbsp;</div>
                                            <div class="col">&nbsp;</div>
                                        </div> 
                                            
                                        <div class="row h-50">
                                            <div class="col border-2 border-end border-success">&nbsp;</div>
                                            <div class="col">&nbsp;</div>
                                        </div>
                                        <h5 class="m-0 ">
                                            <span class="badge rounded-pill  border bg-success">&nbsp;</span>
                                        </h5>
                                    </div>
                                        

                                        <div class="col-10 mx-auto  py-2">
                                                <div class="card radius-15 border-0">
                                                    <div class="card-body ">
                                                        <div>
                                                            <div class="text-center fw-bold" style="width: 100%;
                                                                text-align: center;
                                                                border-bottom: 1px solid #e9edf3;
                                                                line-height: 0.1em;
                                                                margin: 10px auto 15px;"><span style="background: #fff;
                                                                padding: 0 10px;"><img style="padding-bottom: 5px;margin-right: 5px;"  src="{{asset('assets/icon/location-orange.png')}}" />Current Address</span></div>
                                                            <div class="w-10 mx-auto ">SH58, Alandi, Khed, Pune, Maharashtra, 412105, India, SH58, Alandi, Pune, Maharashtra, IN, 412105
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
                        <ul class="nav nav-tabs nav-primary border-0 d-flex justify-content-around " role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active border-0" data-type="1" data-bs-toggle="tab" href="#primaryhome" role="tab" aria-selected="true">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bi bi-home font-18 me-1'></i>
                                </div>
                                <div class="tab-title text-center">
                                <img  src="{{asset('assets/icon/earth.png')}}" />
                                <p class="mb-0">Summary</p>
                                </div>
                                
                            </div>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link  border-0  js-trip-data" data-type="2" data-bs-toggle="tab" href="#stops" role="tab" aria-selected="true">
                                <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bi bi-home font-18 me-1'></i>
                                </div>
                                <div class="tab-title text-center"><img  src="{{asset('assets/icon/location-stop.png')}}" />
                                    <p class="mb-0">Stops</p>
                                </div>
                                </div>
                            </a>
                            </li>
                        
                        <li class="nav-item" role="presentation">
                            <a class="nav-link border-0 js-trip-data" data-type="3" data-bs-toggle="tab" href="#alerts" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                                </div>
                                <div class="tab-title text-center"><img  src="{{asset('assets/icon/alerts.png')}}"/>
                                <p class="mb-0">Alerts</p>
                            </div>
                                
                            </div>
                            </a>
                        </li>
                        {{-- <li class="nav-item" role="presentation">
                            <a class="nav-link border-0 js-trip-data" data-type="4" data-bs-toggle="tab" href="#replay" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-microphone font-18 me-1'></i>
                                </div>
                                <div class="tab-title text-center"><img  src="{{asset('assets/icon/replay.png')}}"/>
                                <p class="mb-0">Replay</p>
                            </div>
                            </div>
                            </a>
                        </li> --}}
                        </ul>
                    </div>
                          </div>
                    </div>
                </div>
           </div>

           <div class="col-12 col-lg-8 col-xxl-8 ">
                <div id="marker-map" style="height: 100%;" class="gmaps"></div>
                 <!-- Bootstrap 5 Tab Structure -->

                 {{-- <div id="bottomDivContainer">
                    <div id="yourBottomDivId">Content of your bottom div goes here</div>
                </div> --}}

                {{-- <div class="container">
                    <ul class="nav nav-tabs" id="myTabs" style="position: absolute;bottom: 10px;z-index: 1000;display: none;"> 
                        <li class="nav-item">
                            <a class="nav-link active" id="tab1" data-bs-toggle="tab" href="#panel1">Tab 1</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab2" data-bs-toggle="tab" href="#panel2">Tab 2</a>
                        </li>
                        <!-- Add more tabs as needed -->
                    </ul>
                    <div class="tab-content mt-2">
                        <div class="tab-pane fade show active" id="panel1">
                            <!-- Content for Tab 1 -->
                        </div>
                        <div class="tab-pane fade" id="panel2">
                            <!-- Content for Tab 2 -->
                        </div>
                        <!-- Add more tab content as needed -->
                    </div>
                </div> --}}

            </div>

           

       </div>
    </div>

@endsection
@push('script-lib')
        <script>
            var mapImage      =  "{{ asset('assets/icon/location-green.png') }}";
            var speedometer   =  "{{ asset('assets/icon/bi_speedometer.png') }}";
            var distanceImage =  "{{ asset('assets/icon/live-tracking.png') }}";
            var batteryImage  =  "{{ asset('assets/icon/battery.png') }}";
            var carImage        =  "{{ asset('assets/icon/car-wireless.png') }}";
            var carKeyImage  =  "{{ asset('assets/icon/car_key.png') }}";
            var distanceCoverImage  =  "{{ asset('assets/icon/distance-cover.png') }}";
            var networkImage =  "{{ asset('assets/icon/network.png') }}";
            
            var longitude_data = '{{ json_encode($longitude_data) }}';
            var trip_details = @json($g_map_data)

            var trip_data = @json($trip_details);
            var coordinates  = @json($trip_complete_data);
            // var trip_complete_data = @json($trip_complete_data);
            var imagePathGreen = "https://gpspackseal.in/assets/icon/vehical_green.svg";
            var ajaxLocationURL = "{{ route('admin.device.live-location-tracking') }}";
            var tokenValue = $('input[name="_token"]').val();
            var p_trip_id = $("#tripId").val();
            
            // console.log(trip_data);
        </script>
        
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvNFKRBGD7GiXGArCB8wXu-fnrXHIFYoc&amp;&libraries=geometry,directions"></script> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <script src="{{ asset('/assets/plugins/gmaps/map-custom-script.js') }}"></script> 
        <script src="{{ asset('/assets/plugins/gmaps/map-custom-live-tracking.js') }}"></script>
        <script>    
            $(document).on('click', '.js-trip-data', function() {
    
                const type = $(this).attr('data-type');
                const tripId = $("#tripId").val();
                // let ajaxURL;
                // if (ajaxURL == 3) {
                //     ajaxURL=  "{{ route('admin.device.get-trip-alert') }}";
                //     console.log(ajaxURL)
                // } 
                $.ajax({
                    type: 'POST',
                    "url": "{{ route('admin.device.get-trip-alert') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    data: {
                        tripId: tripId
                    },
                    dataType: "JSON",
                    success: function(data) {
                        const ajaxDiv = $('#alert_trip');
                        var html ='';
                        for (let i = 0; i < data.length; i++) {
                            const element = data[i];
                            // html += `
                            //         <div class="col-12 mx-auto py-2">
                            //             <div class="card radius-15 border-0">
                            //                 <div class="card-body">
                            //                     <div>
                            //                         <div class="text-left fw-bold" style="width: 100%;
                            //                             text-align: left;
                            //                             border-bottom: 1px solid #e9edf3;
                            //                             line-height: 0.1em;
                            //                             margin: 10px auto 15px;">
                            //                             <span style="background: #fff;
                            //                                 padding: 0 10px;">${element.alert_title}</span>
                            //                         </div>
                            //                         <div class="w-10 mx-auto "><span style="font-size:13px;">Address: ${element.address}</span></div>
                            //                         <div class="w-10 mx-auto "><span style="font-size:13px;">Date:${element.date} </span> <label style="font-size:12px;margin-top:-15px" class="d-flex justify-content-end">RF ID:${element.rf_card_number}</label></div>
                            //                     </div>
                            //                 </div>
                            //             </div>
                            //         </div>`;

                            html += `<div class="col-lg-12 col-md-12 col-sm-12 mx-auto py-2">
                                    <div class="card radius-15 border-0">
                                        <div class="card-body">
                                            <div>
                                                <div class="text-left fw-bold mb-3">
                                                    <span class="bg-light px-3 py-1">${element.alert_title}</span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <span class="font-size-13">Address: ${element.address}</span>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="d-flex justify-content-between">
                                                            <span class="font-size-13">Date: ${element.date}</span>
                                                            <label class="font-size-12">RF ID: ${element.rf_card_number}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `;
                            }
                        ajaxDiv.html(html);
                    }
                });
            });
       
        </script>
@endpush
@push('style-lib')
<style>
    table thead tr th {
      background-color: #2E3192 !important;
      color: #fff!important;
    }
    .device-info .dropdown-menu {
      border: none;
      --bs-dropdown-min-width: 11rem;
    }
    .device-title {
      font-size: 13px;
    }
    .badge {
      --bs-badge-padding-x: 0.5em;
      --bs-badge-padding-y: 0.13em;
    }
    /* .nav-tabs .nav-link.active {
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
    } */
    #bottomDivContainer {
        position: absolute;
        bottom: 0;
        left: 0;
        background-color: #fff;
        /* padding: 10px; */
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        width: 50%;
        left: 0; 
        right: 0; 
        margin-left: auto; 
        margin-right: auto; 
        /* display: none; */
    }
    .gmap {
        font-size: 12px;
        font-weight: 700;
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
   </style>
@endpush