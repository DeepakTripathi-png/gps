@extends('admin.layouts.app')
@section('panel') 
      <div class="row">
          <div class="col-xl-12 mx-auto">
              <div class="card" style="border:none;">
                  <div class="card-header px-4 py-3 d-flex justify-content-between align-items-center">
                      {{-- <div class="row"> --}}
                          <h5 class="mb-0 col-auto">Trips Details:{{$trip_details['trip_id']}} </h5>
                      {{-- </div> --}}
                  
                        <div class="col-md-6 col-lg-12 d-flex justify-content-end" style="width: auto;">
                            <a class="btn btn-primary" style="width: 45px; padding: 0px; background: transparent; border: 1px solid #4caf50;" onclick="redirect()">
                                <img width="35" height="35" src="https://img.icons8.com/color/48/ms-excel.png" alt="ms-excel"/>
                            </a>
                            <a class="btn btn-primary mx-2" style="width: 45px; padding: 0px; background: transparent; border: 1px solid #ff5722;" onclick="redirects()">
                                <img width="26" height="26" style="vertical-align: -webkit-baseline-middle;" src="https://img.icons8.com/color/48/pdf.png" alt="pdf"/>
                            </a>
                        </div>

                        {{-- <div class="col-md-6 col-lg-12" style="display: flex; justify-content: end;">
                            <a class="btn btn-primary" style="width: 40px;padding: 0px;" onclick="redirect()"><i style="font-size: 21px;" class="bi bi-file-earmark-spreadsheet"></i></a>
                            <a class="btn btn-primary mx-2" style="width: 40px;padding: 0px;" onclick="redirects()"><i style="font-size: 21px;" class="bi bi-file-earmark-pdf"></i></a>
                        </div> --}}
                  
                    
                  </div>
                  <div class="card-body p-4">
                      <div class="card">
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
                                      <label for="PhoneNumber" class="form-label">Driver Name:<span class="preview">{{ $trip_details['driver_name']}}</span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                      <label for="PhoneNumber" class="form-label">Container No:<span class="preview">{{ $trip_details['container_no']}}</span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                      <label for="Experience3" class="form-label">Vehicle No:<span class="preview">{{ $trip_details['vehicle_no']}}</span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                      <label for="Experience3" class="form-label">License No:<span class="preview">{{ $trip_details['license_no']}}</span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                      <label for="Experience2" class="form-label">Id Proof No:<span class="preview">{{ $trip_details['id_proof_no']}}</span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                       <label for="PhoneNumber" class="form-label">Mobile No <span class="preview">{{ $trip_details['mobile_no']}}</span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                      <label for="PhoneNumber" class="form-label">Co Driver Name:<span class="preview">{{ $trip_details['co_driver_name']}}</span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                       <label for="Experience2" class="form-label">Co Driver License No:<span class="preview">{{ $trip_details['co_driver_license_no']}}</span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label for="Experience2" class="form-label">Co Drive Id Proof No:<span class="preview">{{ $trip_details['co_drive_id_proof_no']}}</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                          <div class="card-header px-4 py-2 bg-transparent ">
                              <div class="row">
                                  <div class="col-lg-6">
                                      <h6  class="mt-2">Trips Summary</h6>
                                  </div>
                                 
                              </div>
                          </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                  <div class="col-12 col-lg-4">
                                      <label for="Experience1" class="form-label">Trips ID:<span class="preview">{{ $trip_details['trip_id']}}</span></label>
                                  </div>
                                  <div class="col-12 col-lg-4">
                                      <label for="Position1" class="form-label">From Destination:<span class="preview">{{$trip_details['from_location_name']}}</span> </label>
                                  </div>
                                  <div class="col-12 col-lg-4">
                                      <label for="Experience2" class="form-label">To Destination:<span class="preview">{{$trip_details['to_location_name']}}</span></label>
                                  </div>
                                  <div class="col-12 col-lg-4">
                                      <label for="PhoneNumber" class="form-label">Cargo Type:<span class="preview">{{ $trip_details['cargo_type'] }}</span></label>
                                  </div>
                                  <div class="col-12 col-lg-4">
                                      <label for="PhoneNumber" class="form-label">GST No:<span class="preview">{{$trip_details['gstno']}}</span></label>
                                  </div>
                                  <div class="col-12 col-lg-4">
                                      <label for="PhoneNumber" class="form-label">Start Date:<span class="preview">{{date('d-m-Y H:i:s', strtotime($trip_details['start_trip_date']))}}</span></label>
                                  </div>
                                  <div class="col-12 col-lg-4">
                                      <label for="PhoneNumber" class="form-label">Expected Date:<span class="preview">{{date('d-m-Y H:i:s', strtotime($trip_details['expected_arrive_time']))}}</span></label>
                                  </div>
                                  <div class="col-12 col-lg-4">
                                      <label for="PhoneNumber" class="form-label">Shipment Type:<span class="preview">{{$trip_details['shipment_type']}}</span></label>
                                  </div>
                              </div>
                            </div>
                      </div>
                      <div class="card">
                          <div class="card-header px-4 py-2 bg-transparent ">
                              <div class="row">
                                  <div class="col-lg-6">
                                      <h6  class="mt-2">Shipping Details</h6>
                                  </div>
                                  
                              </div>
                          </div>
                          <div class="card-body p-4">
                            <div class="card-body p-4">
                                <div class="row g-4">
                                  <div class="col-12 col-lg-4">
                                      <label for="Experience1" class="form-label">Invoice No:<span class="preview">{{ $trip_details['invoice_no']}}</span></label>
                                  </div>
                                  <div class="col-12 col-lg-4">
                                      <label for="Position1" class="form-label">Invoice Date:<span class="preview">{{date('d-m-Y', strtotime($trip_details['invoice_date']))}}</span> </label>
                                  </div>
                                  <div class="col-12 col-lg-4">
                                      <label for="Experience2" class="form-label">Customer CIF INR:<span class="preview">{{$trip_details['customer_cif_inr']}}</span></label>
                                  </div>
                                  <div class="col-12 col-lg-4">
                                      <label for="PhoneNumber" class="form-label">E Way Bill No:<span class="preview">{{ $trip_details['e_way_bill_no'] }}</span></label>
                                  </div>
                                  <div class="col-12 col-lg-4">
                                      <label for="PhoneNumber" class="form-label">Shipping Details:<span class="preview">{{$trip_details['shipping_details']}}</span></label>
                                  </div>
                                  <div class="col-12 col-lg-4">
                                      <label for="PhoneNumber" class="form-label">Exporter Details:<span class="preview">{{$trip_details['exporter_details']}}</span></label>
                                  </div>
                                  <div class="col-12 col-lg-4">
                                      <label for="PhoneNumber" class="form-label">Start Trip Date:<span class="preview">{{date('d-m-Y', strtotime($trip_details['start_trip_date']))}}</span></label>
                                  </div>
                                  <div class="col-12 col-lg-4">
                                      <label for="PhoneNumber" class="form-label">Expected Arrive Time:<span class="preview">{{date('d-m-Y', strtotime($trip_details['expected_arrive_time']))}}</span></label>
                                  </div>
                                  <div class="col-12 col-lg-4">
                                    <label for="PhoneNumber" class="form-label">Cargo Type:<span class="preview">{{$trip_details['cargo_type']}}</span></label>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label for="PhoneNumber" class="form-label">Shipment Type:<span class="preview">{{$trip_details['shipment_type']}}</span></label>
                                    </div>
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
                                    <div>
                                    </div>
                                    <div class="font-weight-bold text-danger">
                                      <a role="button"  href="{{ asset('invoice_bill/'.$trip_details['invoice_bill']) }}" download="" data-parent="#accordion" id="downloadLink" style="color: black; font-weight: 600;">
                                       <img class="p-1" data-toggle="tooltip" data-placement="top" title="Shipment"  src="{{asset('assets/icon/download.png')}}" />Invoice Bill
                                     </a>
                                    </div>
                                  </div>   
                                </div>
                                <div class="col-12 col-lg-4">
                                  <div class="d-flex align-items-center">
                                    <div><i class="bx bxs-file-pdf me-2 font-24 text-danger"></i></div>
                                    <div class="font-weight-bold text-danger">
                                      <a role="button"  href="{{ asset('unexture_a/'.$trip_details['custom_unexture_a']) }}" download="" data-parent="#accordion" id="downloadLink" style="color: black; font-weight: 600;">
                                        <img class="p-1" data-toggle="tooltip" data-placement="top" title="Shipment"  src="{{asset('assets/icon/download.png')}}" /> Custom Unexture-A
                                      </a>
                                    </div>
                                    
                                  </div>   
                                </div>
                                <div class="col-12 col-lg-4">
                                  <div class="d-flex align-items-center">
                                    <div><i class="bx bxs-file-pdf me-2 font-24 text-danger"></i></div>
                                    <div class="font-weight-bold text-danger">
                                      <a role="button"  href="{{ asset('unexture_b/'.$trip_details['custom_unexture_b']) }}" download="" data-parent="#accordion" id="downloadLink" style="color: black; font-weight: 600;">
                                        <img class="p-1" data-toggle="tooltip" data-placement="top" title="Shipment"  src="{{asset('assets/icon/download.png')}}" /> Custom Unexture-B
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
@endsection   
@push('script')
<script>
function redirect() {
    
    var params = getTripIdFromUrl();
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
    var params = getTripIdFromUrl();
;

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

function getTripIdFromUrl() {
    var currentUrl = window.location.href;

    var urlSearchParams = new URLSearchParams(currentUrl);

    var tripId = urlSearchParams.get('trip_id');

    if (tripId !== null) {
        return{trip_id: tripId};
    } else {
        
        return null;
    }
}

</script>
@endpush