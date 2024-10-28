@extends('admin.layouts.app')
@section('panel') 
        <h5>{{$pagetitle}}</h5>
        <hr>
        @can('admin.trips.add-trip')
          <div id="stepper2" class="bs-stepper">
              <div class="card">
                  <div class="card-header bg-transparent">
                      <div class="d-lg-flex flex-lg-row align-items-lg-center justify-content-lg-between" role="tablist">
                          <div class="step" data-target="#test-nl-1">
                          <div class="step-trigger" role="tab" id="stepper2trigger1" aria-controls="test-nl-1">
                              <div class="bs-stepper-circle"><img class="p-1" data-toggle="tooltip" data-placement="top" title="Device Configuration"  src="{{asset('assets/icon/device-config.png')}}" /></div>
                              <div class="">
                                  <h5 class="mb-0 steper-title">Device Configuration</h5>
                              </div>
                          </div>
                          </div>
                          <div class="bs-stepper-line"></div>
                          <div class="step" data-target="#test-nl-2">
                              <div class="step-trigger" role="tab" id="stepper2trigger2" aria-controls="test-nl-2">
                              <div class="bs-stepper-circle"><img class="p-1" data-toggle="tooltip" data-placement="top" title="Container Details"  src="{{asset('assets/icon/container-outlined.png')}}" /></div>
                              <div class="">
                                  <h5 class="mb-0 steper-title">Container Details</h5>
                              </div>
                              </div>
                          </div>
                          <div class="bs-stepper-line"></div>
                          <div class="step" data-target="#test-nl-3">
                              <div class="step-trigger" role="tab" id="stepper2trigger3" aria-controls="test-nl-3">
                              <div class="bs-stepper-circle"><img class="p-1" data-toggle="tooltip" data-placement="top" title="Shipping Details"  src="{{asset('assets/icon/shipping-fast.png')}}" /></div>
                              <div class="">
                                  <h5 class="mb-0 steper-title">Shipping Details</h5>
                              </div>
                              </div>
                          </div>
                          <div class="bs-stepper-line"></div>
                              <div class="step" data-target="#test-nl-4">
                                  <div class="step-trigger" role="tab" id="stepper2trigger4" aria-controls="test-nl-4">
                                  <div class="bs-stepper-circle"><img class="p-1" data-toggle="tooltip" data-placement="top" title="Preview Details"  src="{{asset('assets/icon/codicon_preview.png')}}" /></div>
                                  <div class="">
                                      <h5 class="mb-0 steper-title">Preview Details</h5>
                                  </div>
                                  </div>
                              </div>
                      </div>
                  </div>
                  <div class="card-body">
                  
                  <div class="bs-stepper-content">
                    <form id="assing_trip" action="{{ isset($trip_edit) ? route('admin.trips.update-trip',['id' => $trip_edit['id']] ) : route('admin.trips.add-trip') }}" method="POST" enctype="multipart/form-data">

                      {{-- <form id="assing_trip" action="{{ route('admin.trips.add-trip') }}" method="POST" enctype="multipart/form-data"> --}}
                        @csrf
                      <div id="test-nl-1" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper2trigger1">
                          <div class="row g-3">
                            <div class="col-md-4">
                              <label class="form-label required">Device<span class="text-danger">*</span></label>
                              <select  name="device" class="form-select js-select-dropdown" data-id="#preview-device" required>
                                  <option value="">Select Device</option>
                                  @isset($gps_devices)
                                    @forelse ($gps_devices as $gps_device)
                                      @if (isset($trip_edit['gps_devices_id']))
                                      <option value="{{ $gps_device->id }}" @if(old('gps_devices_id', $gps_device->id) == $trip_edit['gps_devices_id']) selected @endif>{{ $gps_device->device_id }}</option>
                                      @else
                                      <option value="{{ $gps_device->id }}">{{ $gps_device->device_id }}</option>
                                      @endif
                                    @empty
                                      <p>No Device</p>
                                    @endforelse
                                  @endisset
                              </select>
                          </div>
                            
                              <div class="col-md-4">
                                <label for="" class="form-label required">From Destination<span class="text-danger">*</span></label>
                                <select id="" name="from_destination" class="form-select js-trip-location js-select-dropdown" data-id="#preview-from-destination" data-id="1"  required>
                                    <option value="">Select From Destination</option>
                                    @isset($locations)
                                      @forelse ($locations as $location)
                                          @if (isset($trip_edit['from_destination']))
                                          <option value="{{ $location->id }}" @if(old('from_destination', $location->id) == $trip_edit['from_destination']) selected @endif>{{ $location->location_port_name }}</option>
                                          @else
                                          <option value="{{ $location->id }}">{{ $location->location_port_name }}</option>
                                          @endif
                                      @empty
                                        <p>No From Destination</p>
                                      @endforelse
                                    @endisset
                                </select>
                              </div>
                              <div class="col-md-4">
                                <label class="form-label required">to Destination<span class="text-danger">*</span></label>
                                <select  name="to_destination" class="form-select js-trip-location js-select-dropdown" data-id="#preview-to-destination" data-id="2" required>
                                    <option value="">Select to Destination</option>
                                      @isset($locations)
                                        @forelse ($locations as $location)
                                          @if (isset($trip_edit['from_destination']))
                                          <option value="{{ $location->id }}" @if(old('to_destination', $location->id) == $trip_edit['to_destination']) selected @endif>{{ $location->location_port_name }}</option>
                                          @else
                                          <option value="{{ $location->id }}">{{ $location->location_port_name }}</option>
                                          @endif
                                        @empty
                                        <p>No From Destination</p>
                                      @endforelse
                                  @endisset
                                </select>
                            </div>
                          
                              <div class="col-12 col-lg-12" >
                                  <button class="btn btn-primary px-4 test-nl-1-next next-button" type="button" style="float: right;">Next<i class='bx bx-right-arrow-alt ms-2'></i></button>
                              </div>
                          </div><!---end row-->
                          
                      </div>

                      <div id="test-nl-2" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper2trigger2">
                          <div class="row g-3">
                              <div class="col-12 col-lg-4">
                                  <label for="InputUsername2" class="form-label required">Driver Name<span class="text-danger">*</span></label>
                                  <input type="text" class="form-control js-ps-input" name="driver_name" value="{{ old('driver_name', $trip_edit['driver_name'] ?? '') }}" data-id="#preview-driver-name" id="driver_name" placeholder="Driver Name">
                              </div>

                              <div class="col-12 col-lg-4">
                                <label for="InputUsername2" class="form-label required"><span class="text-danger">*</span>Container No.</label>
                                <input type="text" class="form-control js-ps-input" name="container_no" value="{{ old('container_no', $trip_edit['container_no'] ?? '') }}" data-id="#preview-customer-no" id="container_no"  placeholder="Container No.">
                              </div>
                              <div class="col-12 col-lg-4">
                                <label for="InputUsername2" class="form-label required">Vehicle No.<span class="text-danger">*</span></label>
                                <input type="text" class="form-control js-ps-input" name="vehicle_no" value="{{ old('vehicle_no', $trip_edit['vehicle_no'] ?? '') }}" data-id="#preview-vehicle-no" placeholder="Vehicle No.">
                              </div>
                              <div class="col-12 col-lg-4">
                                <label for="InputUsername2" class="form-label required">License No.<span class="text-danger">*</span></label>
                                <input type="text" class="form-control js-ps-input" name="license_no" value="{{ old('license_no', $trip_edit['license_no'] ?? '') }}" data-id="#preview-license-no" placeholder="License No.">
                              </div>
                              <div class="col-12 col-lg-4">
                                <label for="InputUsername2" class="form-label required">ID Proof No.<span class="text-danger">*</span></label>
                                <input type="text" class="form-control js-ps-input" name="id_proof_no" value="{{ old('id_proof_no', $trip_edit['id_proof_no'] ?? '') }}" data-id="#preview-id-proof-no" id="id_proof_no" placeholder="ID Proof No.">
                              </div>
                              <div class="col-12 col-lg-4">
                                <label for="InputUsername2" class="form-label required">Mobile No.<span class="text-danger">*</span></label>
                                <input type="number" class="form-control js-ps-input" name="mobile_no" value="{{ old('mobile_no', $trip_edit['mobile_no'] ?? '') }}" data-id="#preview-mobile-no" id="mobile_no" placeholder="Mobile No.">
                              </div>
                              <div class="col-12 col-lg-4">
                                <label for="InputUsername2" class="form-label required">Co-Driver Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control js-ps-input" name="co_driver_name" value="{{ old('co_driver_name', $trip_edit['co_driver_name'] ?? '') }}" data-id="#preview-co-driver-name" id="co_driver_name" placeholder="Co-Driver Name">
                              </div>
                              <div class="col-12 col-lg-4">
                                <label for="InputUsername2" class="form-label required">Co-Driver License No.<span class="text-danger">*</span></label>
                                <input type="text" class="form-control js-ps-input" data-id="#preview-co-driver-license-no" value="{{ old('co_driver_license_no', $trip_edit['co_driver_license_no'] ?? '') }}" name="co_driver_license_no" id="co_driver_license_no" placeholder="Co-Driver License No.">
                              </div>
                              <div class="col-12 col-lg-4">
                                <label for="InputUsername2" class="form-label required">Co-Drive ID Proof No.<span class="text-danger">*</span></label>
                                <input type="text" class="form-control js-ps-input" name="co_drive_id_proof_no" value="{{ old('co_drive_id_proof_no', $trip_edit['co_drive_id_proof_no'] ?? '') }}" data-id="#preview-co-drive-id-proof-no"  id="co_drive_id_proof_no" placeholder="Co-Drive ID Proof No.">
                              </div>
                              <div class="col-12">
                                  <div class="d-flex align-items-center gap-3"  style="float: right;">
                                      <button type="button" class="btn btn-outline-secondary px-4 test-nl-2-previous prev-button"><i class='bx bx-left-arrow-alt me-2'></i>Previous</button>
                                      <button type="button" class="btn btn-primary px-4 next-button test-nl-2-next">Next<i class='bx bx-right-arrow-alt ms-2'></i></button>
                                  </div>
                              </div>
                          </div><!---end row-->
                      </div>

                      <div id="test-nl-3" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper2trigger3">
                          <div class="row g-3">

                              <div class="col-12 col-lg-4">
                                <label class="form-label required">Start Trip Date<span class="text-danger">*</span></label>
                                <input type="text" class="form-control data-time-start js-ps-input"  value="{{ old('start_trip_date', $trip_edit['start_trip_date'] ?? '') }}" name="start_trip_date" data-id="#preview-start-trip-date" placeholder="Start Trip Date">
                              </div>

                              <div class="col-12 col-lg-4">
                                <label class="form-label required">Expected Arrival Time<span class="text-danger">*</span></label>
                                <input type="text" class="form-control data-time-arrive js-ps-input" value="{{ old('expected_arrive_time', $trip_edit['expected_arrive_time'] ?? '') }}" name="expected_arrive_time" data-id="#preview-expected-arrive-time" placeholder="Start Trip Date">
                              </div>

                              <div class="col-12 col-lg-4">
                                <label class="form-label required">Cargo Type<span class="text-danger">*</span></label>
                                  <select  name="cargo_type" class="form-select js-select-dropdown" data-id="#preview-cargo-type"  required>
                                    <option value="">Select Type</option>
                                    <option value="By Road" @if(old('cargo_type', 'By Road') == isset($trip_edit['cargo_type'])) selected @endif>By Road</option>
                                    <option value="Railway" @if(old('cargo_type', 'Railway') == isset($trip_edit['cargo_type'])) selected @endif>Railway</option>
                                    <option value="Airline" @if(old('cargo_type', 'Airline') == isset($trip_edit['cargo_type'])) selected @endif>Airline</option>
                                    <option value="Vessel" @if(old('cargo_type', 'Vessel') == isset($trip_edit['cargo_type'])) selected @endif>Vessel</option>
                                </select>
                              </div>

                              <div class="col-12 col-lg-4">
                                <label class="form-label required">Shipment Type<span class="text-danger">*</span></label>
                                  <select  name="shipment_type" class="form-select js-select-dropdown" data-id="#preview-shipment-type"  required>
                                    <option value="">Select Type</option>
                                    <option value="Domestic" @if(old('shipment_type', 'Domestic') == isset($trip_edit['shipment_type'])) selected @endif>Domestic</option>
                                    <option value="International" @if(old('shipment_type', 'International') == isset($trip_edit['shipment_type'])) selected @endif>International</option>
                                </select>
                              </div>

                              <div class="col-12 col-lg-4">
                                  <label class="form-label required">Invoice No.<span class="text-danger">*</span></label>
                                  <input type="text" class="form-control js-ps-input" value="{{ old('invoice_no', $trip_edit['invoice_no'] ?? '') }}" name="invoice_no" data-id="#preview-invoice-no" placeholder="Invoice No.">
                              </div>
                              <div class="col-12 col-md-4">
                                <label class="form-label required">Invoice Date<span class="text-danger">*</span></label>
                                <input type="text" class="form-control datepicker js-ps-input" value="{{ old('invoice_date', $trip_edit['invoice_date'] ?? '') }}" name="invoice_date" data-id="#preview-invoice-date" required>
                            </div>
                              <div class="col-12 col-lg-4">
                                  <label for="BoardName2" class="form-label required">Customer CIF Value in INR<span class="text-danger">*</span></label>
                                  <input type="number" class="form-control js-ps-input" name="customer_cif_inr" value="{{ old('customer_cif_inr', $trip_edit['customer_cif_inr'] ?? '') }}" data-id="#preview-customer-cif-value-inr" placeholder="Customer CIF Value in INR">
                              </div>
                              <div class="col-12 col-lg-4">
                                  <label class="form-label required">E-Way Bill no.<span class="text-danger">*</span></label>
                                  <input type="text" class="form-control js-ps-input" name="e_way_bill_no" value="{{ old('e_way_bill_no', $trip_edit['e_way_bill_no'] ?? '') }}" data-id="#preview-e-way-bill-no"  placeholder="E-Way Bill no.">
                              </div>
                              <div class="col-12 col-lg-4">
                                <label class="form-label required">Shipping Details<span class="text-danger">*</span></label>
                                <input type="text" class="form-control js-ps-input" name="shipping_details" value="{{ old('shipping_details', $trip_edit['shipping_details'] ?? '') }}" data-id="#preview-shipping-details" placeholder="Shipping Details">
                            </div>
                            <div class="col-12 col-lg-4">
                                <label class="form-label required">Exporter Details<span class="text-danger">*</span></label>
                                <input type="text" class="form-control js-ps-input" name="exporter_details" value="{{ old('exporter_details', $trip_edit['exporter_details'] ?? '') }}" data-id="#preview-exporter-details" placeholder="Exporter Details">
                            </div>
                            <div class="col-md-4">
                              <label class="form-label ">Upload Invoice Bill</label>
                              <input class="form-control js-trip-doc" type="file" data-id="#preview-upload-invoice"  name="invoice_bill"  id="formFile">
                              @if(isset($trip_edit['invoice_bill']) && !empty($trip_edit['invoice_bill']))  
                               <div class="d-flex">
                                <a target="_blank" href="{{ asset('invoice_bill/'.$trip_edit['invoice_bill']) }}" class="mr-2 d-inline-block mt-2 d-block underline" style="text-decoration: underline;">Download</a>
                                {{-- <a target="" href="" class="d-inline-block mt-2 d-block underline js-delete-file"  type="1" data-id="{{ isset($trip_edit) ? $trip_edit['id'] : '' }}" style="text-decoration: underline;"> <img data-toggle="tooltip" data-placement="top" title="Download"  src="{{asset('assets/icon/delete.png')}}" /></a> --}}
                               </div>
                              @endif
                            </div>
                            <div class="col-md-4">
                              <label for="formFile" class="form-label">Upload Custom Unexture-A</label>
                              <input class="form-control js-trip-doc" type="file" data-id="#preview-custom-unexture-a" name="unexture_a">
                              @if(isset($trip_edit['custom_unexture_a']) && !empty($trip_edit['custom_unexture_a'])) 
                              <div class="d-flex">
                                <a target="_blank" href="{{ asset('unexture_a/'.$trip_edit['custom_unexture_a']) }}" class="mr-2 d-inline-block mt-2 d-block underline" style="text-decoration: underline;">Download</a>
                                {{-- <a target="" href="" class="d-inline-block mt-2 d-block underline js-delete-file" type="1" data-id="{{ isset($trip_edit) ? $trip_edit['id'] : '' }}" style="text-decoration: underline;"> <img data-toggle="tooltip" data-placement="top" title="Download"  src="{{asset('assets/icon/delete.png')}}" /></a> --}}
                               </div> 
                              @endif
                            </div>
                            <div class="col-md-4">
                              <label for="formFile" class="form-label">Upload Custom Unexture-B</label>
                              <input class="form-control js-trip-doc" type="file" data-id="#preview-custom-unexture-b"  name="unexture_b">
                              @if(isset($trip_edit['custom_unexture_b']) && !empty($trip_edit['custom_unexture_b']))  
                              <div class="d-flex">
                                <a target="_blank" href="{{ asset('unexture_b/'.$trip_edit['custom_unexture_b']) }}" class="mr-2 d-inline-block mt-2 d-block underline" style="text-decoration: underline;">Download</a>
                                {{-- <a target="" href="" class="d-inline-block mt-2 d-block underline js-delete-file" type="1" data-id="{{ isset($trip_edit) ? $trip_edit['id'] : '' }}" style="text-decoration: underline;"> <img data-toggle="tooltip" data-placement="top" title="Download"  src="{{asset('assets/icon/delete.png')}}" /></a> --}}
                               </div>
                              @endif
                            </div>
                              <div class="col-12">
                                  <div class="d-flex align-items-center gap-3" style="float: right;">
                                      <button type="button" class="btn btn-outline-secondary px-4 test-nl-3-previous"><i class='bx bx-left-arrow-alt me-2'></i>Previous</button>
                                      <button type="button" class="btn btn-primary px-4 test-nl-3-next">Next<i class='bx bx-right-arrow-alt ms-2'></i></button>
                                  </div>
                              </div>
                          </div><!---end row-->
                          
                      </div>

                      <div id="test-nl-4" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper2trigger4">
                            <div class="row g-3">
                              <div class="col-12 col-lg-4">
                                  <label class="form-label">Device:<span class="preview" id="preview-device"></span></label>
                              </div>
                              <div class="col-12 col-lg-4">
                                  <label class="form-label">From Destination:<span class="preview" id="preview-from-destination"></span> </label>
                              </div>
                              <div class="col-12 col-lg-4">
                                  <label  class="form-label">To Destination:<span class="preview" id="preview-to-destination"></span></label>
                              </div>
                              <div class="col-12 col-lg-4">
                                  <label class="form-label">Driver Name:<span class="preview" id="preview-driver-name">{{ old('driver_name', $trip_edit['driver_name'] ?? '') }}</span></label>
                              </div>
                              <div class="col-12 col-lg-4">
                                  <label class="form-label">Container No:<span class="preview" id="preview-customer-no">{{ old('container_no', $trip_edit['container_no'] ?? '') }}</span></label>
                              </div>
                              <div class="col-12 col-lg-4">
                                  <label class="form-label">Vehicle No:<span class="preview" id="preview-vehicle-no">{{ old('vehicle_no', $trip_edit['vehicle_no'] ?? '') }}</span></label>
                              </div>
                              <div class="col-12 col-lg-4">
                                <label class="form-label">License No:<span class="preview" id="preview-license-no">{{ old('license_no', $trip_edit['license_no'] ?? '') }}</span></label>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label class="form-label">ID Proof No:<span class="preview" id="preview-id-proof-no">{{ old('id_proof_no', $trip_edit['id_proof_no'] ?? '') }}</span></label>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label class="form-label">Mobile No:<span class="preview" id="preview-mobile-no">{{ old('mobile_no', $trip_edit['mobile_no'] ?? '') }}</span></label>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label class="form-label">Co-Driver Name:<span class="preview" id="preview-co-driver-name">{{ old('co_driver_name', $trip_edit['co_driver_name'] ?? '') }}</span></label>
                            </div>
                            <div class="col-12 col-lg-4">
                              <label class="form-label">Co-Driver License No:<span class="preview" id="preview-co-driver-license-no">{{ old('co_driver_license_no', $trip_edit['co_driver_license_no'] ?? '') }}</span></label>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label class="form-label">Co-Driver ID Proof No:<span class="preview" id="preview-co-drive-id-proof-no">{{ old('co_drive_id_proof_no', $trip_edit['co_drive_id_proof_no'] ?? '') }}</span></label>
                            </div>

                            <div class="col-12 col-lg-4">
                              <label class="form-label">Start Trip Date:<span class="preview" id="preview-start-trip-date">{{ old('start_trip_date', $trip_edit['start_trip_date'] ?? '') }}</span></label>
                          </div>
                          <div class="col-12 col-lg-4">
                            <label class="form-label">Expected Arrival Time:<span class="preview" id="preview-expected-arrive-time">{{ old('expected_arrive_time', $trip_edit['expected_arrive_time'] ?? '') }}</span></label>
                          </div>
                          <div class="col-12 col-lg-4">
                              <label class="form-label">Cargo Type:<span class="preview" id="preview-cargo-type">{{ old('cargo_type', $trip_edit['cargo_type'] ?? '') }}</span></label>
                          </div>
                          <div class="col-12 col-lg-4">
                            <label class="form-label">Shipment Type:<span class="preview" id="preview-shipment-type">{{ old('shipment_type', $trip_edit['cargo_type'] ?? '') }}</span></label>
                        </div>

                            <div class="col-12 col-lg-4">
                              <label class="form-label">Invoice No:<span class="preview" id="preview-invoice-no">{{ old('invoice_no', $trip_edit['invoice_no'] ?? '') }}</span></label>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label class="form-label">Invoice Date:<span class="preview" id="preview-invoice-date">{{ old('invoice_date', $trip_edit['invoice_date'] ?? '') }}</span></label>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="Experience3" class="form-label">Customer CIF Value in INR:<span class="preview" id="preview-customer-cif-value-inr">{{ old('customer_cif_inr', $trip_edit['customer_cif_inr'] ?? '') }} </span>INR </label>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="PhoneNumber" class="form-label">E-Way Bill no:<span class="preview" id="preview-e-way-bill-no">{{ old('e_way_bill_no', $trip_edit['e_way_bill_no'] ?? '') }}</span></label>
                            </div>
                            <div class="col-12 col-lg-4">
                              <label for="PhoneNumber" class="form-label">Shipping Details:<span class="preview" id="preview-shipping-details">{{ old('shipping_details', $trip_edit['shipping_details'] ?? '') }}</span> </label>
                            </div>
                            <div class="col-12 col-lg-4">
                              <label for="Experience3" class="form-label">Select Exporter Details:<span class="preview" id="preview-exporter-details">{{ old('exporter_details', $trip_edit['exporter_details'] ?? '') }}</span></label>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="PhoneNumber" class="form-label">Uploaded Invoice:<span class="preview" id="preview-upload-invoice">{{ old('invoice_bill', $trip_edit['invoice_bill'] ?? '') }}</span></label>
                            </div>
                            <div class="col-12 col-lg-4">
                              <label for="Experience2" class="form-label">Uploaded Custom Unexture-A:<span class="preview" id="preview-custom-unexture-a">{{ old('custom_unexture_a', $trip_edit['custom_unexture_a'] ?? '') }}</span></label>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="PhoneNumber" class="form-label">Uploaded Custom Unexture-B:<span class="preview" id="preview-custom-unexture-b">{{ old('custom_unexture_b', $trip_edit['custom_unexture_b'] ?? '') }}</span></label>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center gap-3"  style="float: right;">
                                    <button type="button" class="btn btn-primary px-4 prev-button test-nl-4-previous"><i class='bx bx-left-arrow-alt me-2'></i>Previous</button>
                                    <button class="btn btn-success px-4 next-button test-nl-4-next" name="submit" type="submit">Submit</button>
                                </div>
                            </div>
                          </div><!---end row-->
                          
                      </div>
                      </form>
                  </div>
                      
                  </div>
                  </div>
          </div>
        @endcan

		<!--end row-->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-borderd dc-table" style="border-collapse: collapse!important;">
                      @csrf
                        <thead>
                            <tr>
                                @can(['admin.trips.edit-trip', 'admin.trips.trip-details'])
                                  <th>Action</th>
                                @endcan
                                <th>Sr No.</th>
                                <th>Trip ID</th>
                                <th data-orderable="false">Device Status</th>
                                <th data-orderable="false">Cargo Type</th>
                                <th data-orderable="false">Shipment Type</th>
                                <th data-orderable="false">Location</th>
                                <th data-orderable="false" style="max-width: 200px;">Current Address</th>
                                <th data-orderable="false">Driver name</th>
                                <th data-orderable="false">Vehicle No</th>
                                <th data-orderable="false">Contact No</th>
                                <th data-orderable="false">Start Date</th>
                                <th data-orderable="false">Exp Arrival Date</th>
                                <th data-orderable="false">Trip Comp. Date</th>
                                <th data-orderable="false">Last Update At</th>
                                <th data-orderable="false">Trip Status</th>
                               
                             </tr>
                        </thead>
                      
                    </table>
                </div>
            </div>
        </div>  

     <div class="modal fade" id="deviceNotification" tabindex="-1"> 
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirmation Alert!</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Are you sure you want to Unlock device?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
            <button type="button" class="btn btn-primary confirm-unlock-device">Yes</button>
          </div>
        </div>
      </div>
    </div>
    
    {{-- @can('admin.hotel.room.status') --}}
      <x-confirmation-modal />
    {{-- @endcan --}}

    @endsection
    @push('script-lib')
    <script src="{{ asset("/assets/plugins/bs-stepper/js/bs-stepper.min.js") }}"></script>
    <script src="{{ asset("/assets/plugins/bs-stepper/js/main.js") }}"></script>
    <script src="{{ asset("/assets/plugins/datatable/js/jquery.dataTables.min.js") }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @endpush

    @push('style-lib')
      <link href="{{ asset("/assets/plugins/bs-stepper/css/bs-stepper.css") }}" rel="stylesheet">
      <link href="{{ asset("/assets/flatpickr/dist/flatpickr.min.css") }}" rel="stylesheet">
      <link rel="stylesheet" href="{{ asset("assets/select2-bootstrap-5-theme%401.3.0/dist/select2-bootstrap-5-theme.min.css") }}" />
    <style>
      table thead tr th {
        background-color: #2E3192 !important;
        color: #fff!important;
      }
      .preview{
        font-weight: 800; 
        font-size: 16px;
      }
      #example2 tr td:nth-child(8) {
        max-width: 200px;
        white-space: inherit;
      }
     </style>
    @endpush

    @push('script')
	 <script>
		$(document).ready(function() {
			$('#example').DataTable();
		  } );
	 </script>
	 <script>
		$(document).ready(function() {
			var table = $('#example2').DataTable({
        // "scrollX": true,
		    "dom": 'Bfrtip',
        "lengthMenu": [[25, 50, 75, 100, 125,150, -1],
          [ '25 rows', '50 rows', '75 rows',  '100 rows',  '125 rows',  '150 rows', 'Show all' ]
        ],
        "paging": true,
        "iDisplayLength": 10,
        processing: true,
        serverSide: true,
        "ajax": {
          "url": "{{ route('admin.trips.assign.trips') }}",
          "type": "POST",
          'headers': {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
        },
        "ordering": true,
        order: [[1, 'asc']],
        buttons: [
          {
            extend: 'excel',
            exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9,10,11,12,13,14,15] 
            }
          },
          {
            extend: 'print',
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9,10,11,12,13,14,15] 
            }
          }
        ]
			});
		//	table.buttons().container().appendTo( '#example2_wrapper .col-md-6:eq(0)');
       $('[data-toggle="tooltip"]').tooltip();
    });
     
	 </script>
   <script>
    var date = @json(isset($edit_trip) && !empty($edit_trip) ?  : date('Y-m-d H:i:s'));
    console.log(date);

    $(".datepicker").flatpickr();
      $(".data-time-start").flatpickr({
        enableTime: true,
        enableSeconds: true,
        dateFormat: "Y-m-d H:i:S",
        minuteIncrement:1,
        onChange: function(selectedDates, dateStr, instance) {
        instance.close();
        },
        minDate: "today",
        // defaultDate: new Date(),
        defaultDate: "{{ isset($trip_edit) ? $trip_edit['start_trip_date'] : date('Y-m-d H:i:s') }}",
      });
      $(".data-time-arrive").flatpickr({
        enableTime: true,
        enableSeconds: true,
        dateFormat: "Y-m-d H:i:S",
        minuteIncrement:1,
        minDate: "today",
        onChange: function(selectedDates, dateStr, instance) {
        instance.close();
        },
        // defaultDate: new Date(),
        defaultDate: "{{ isset($trip_edit) ? $trip_edit['expected_arrive_time'] : date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s') . ' +7 days')) }}",
      });
   // });
   $(".device-lock-alert").click(function() {
    $("#deviceNotification").modal('show');
   });

   $(".confirm-unlock-device").click(function() {
    $("#deviceNotification").modal('hide');
    success_noti();
   });
   
  $(".js-trip-location").change(function() {
    const id = $(this).val();
    const locationSelectId = $(this).attr('data-id');

    var selectedValue = $(this).val();
    $(".js-trip-location option").each(function () {
      if ($(this).val() === selectedValue) {
        $(this).hide();
      } else {
        $(this).show();
      }
    });
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

  function goToNextStep(step) {
  }

  $("#assing_trip").validate({
    highlight: function(element) {
        $(element).addClass("is-invalid").removeClass("is-valid");
    },
    unhighlight: function(element) {
          $(element).addClass("is-valid").removeClass("is-invalid");
    },
    rules: {
      device: {required: true},
      from_destination: {required: true},
      to_destination: {required: true},
      driver_name:{required: true},
      container_no:{required: true},
      vehicle_no:{required: true},
      license_no:{required: true},
      id_proof_no:{required: true},
      mobile_no:{required: true},
      co_driver_name:{required: true},
      co_driver_license_no:{required: true},
      co_drive_id_proof_no:{required: true},
      invoice_no:{required: true},
      invoice_date:{required: true},
      customer_cif_inr:{required: true},
      e_way_bill_no:{required: true},
      shipping_details:{required: true},
      exporter_details:{required: true},
      // invoice_bill:{required: true},
      // unexture_a:{required: true},
      // unexture_b:{required: true},
      start_trip_date:{required: true},
      expected_arrive_time:{required: true},
      cargo_type:{required: true},
      shipment_type:{required: true},
    },
    messages: {
      device:"Please select a valid Device.",
      from_destination:"Please select a valid From Destination.",
      to_destination:"Please select a valid to Destination."
    }
  });

  $(".test-nl-1-next").click(function() {
    const isValid = $("#assing_trip").valid();
    if(isValid == false) {
      return false;
    }
    $(".step").removeClass('active');
    $(".step[data-target = '#test-nl-2']").addClass('active');
    $("#test-nl-1").hide();
    $("#test-nl-2").show();
    $("#test-nl-3").hide();
    $("#test-nl-4").hide();

  });

  $(".test-nl-2-next").click(function() {
    const isValid = $("#assing_trip").valid();
    if(isValid == false) {
      return false;
    }
    $(".step").removeClass('active');
    $(".step[data-target = '#test-nl-3']").addClass('active');
    $("#test-nl-1").hide();
    $("#test-nl-2").hide();
    $("#test-nl-3").show();
    $("#test-nl-4").hide();
  });

  $(".test-nl-3-next").click(function() {
    const isValid = $("#assing_trip").valid();
    if(isValid == false) {
      return false;
    }
    $(".step").removeClass('active');
    $(".step[data-target = '#test-nl-4']").addClass('active');
    $("#test-nl-1").hide();
    $("#test-nl-2").hide();
    $("#test-nl-3").hide();
    $("#test-nl-4").show();
  });


  $(".test-nl-2-previous").click(function() {
    $("#test-nl-1").show();
    $("#test-nl-2").hide();
    $("#test-nl-3").hide();
    $("#test-nl-4").hide();
    $(".step").removeClass('active');
    $(".step[data-target = '#test-nl-1']").addClass('active');
  });

  $(".test-nl-3-previous").click(function() {
    $("#test-nl-1").hide();
    $("#test-nl-2").show();
    $("#test-nl-3").hide();
    $("#test-nl-4").hide();
    $(".step").removeClass('active');
    $(".step[data-target = '#test-nl-2']").addClass('active');
  });

  $(".test-nl-4-previous").click(function() {
    $("#test-nl-1").hide();
    $("#test-nl-2").hide();
    $("#test-nl-3").show();
    $("#test-nl-4").hide();
    $(".step").removeClass('active');
    $(".step[data-target = '#test-nl-3']").addClass('active');
  });

  $(".js-select-dropdown").change(function() {
    const text = $(this).find('option:selected').text();
    const id = $(this).attr('data-id');
    $(`${id}`).text(text);
  });

  $(".step").click(function() {
    $(".js-select-dropdown").change();
  });

  $(".js-ps-input").keyup(function() {
    const value = $(this).val();
    const id = $(this).attr('data-id');
    $(`${id}`).text(value);
  }); 

  $(".js-trip-doc").change(function(){
    const files = $(this)[0].files[0];
    const id = $(this).attr('data-id');
    const value = files.name;
    $(`${id}`).text(value);
  });

  $(".datepicker").change(function(){
    const value = $(this).val();
    const id = $(this).attr('data-id');
    $(`${id}`).text(value);
  });

  $(".js-ps-trip-completed").click(function() {

  });

  $(".js-delete-file").click(function(){
    const type = $(this).attr('type');
    const id  = $(this).attr('data-id');
      $.ajax({
        type: 'POST',
        data:{
          type,
          id
        },
        url: 'remove-file',
        success: function (data) {
      }
    });
  });
  
  // $(".js-device-details").click(function() {
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
