<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $general->siteName('Booking Transaction Details') }}</title>
    <style>
         @page {
            size: 9.07in 11.7in!important;
            margin: .0in!important;
            }

        body {
            font-family: "Poppins", sans-serif;
            text-align: left;
            font-size: 11px; 
        }

        .transactions table {
            width: 50%; 
            border-collapse: collapse;
            margin-bottom: 20px;
            overflow-x: auto; 
            margin-left: 2%; 
        }

        .transactions tr, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .transactions th {
            background-color: #f2f2f2;
        }

        .center-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .center-container div {
            overflow-x: auto;
        }

        table {
            border-collapse: collapse;
            margin-bottom: 20px;
            overflow-x: auto; 
            margin:2%; 
            width:96%;

        }

        tr, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        th {
            border: 1px solid #ddd;
            background-color: #c6efce;
            text-align: center;
            padding: 5px;
          
        }
    </style>
</head>
<body>
    <div class="row" style="text-align: center;">
            @if (isset($is_pdf_trip) && !empty($is_pdf_trip))
                <h3>Trip Summary Details</h3>
            @else
                <h3>Device Summary  Details</h3>
            @endif
           
    </div>
    <div style="overflow-x:auto;" class="transactions">
        <table>
            @if (isset($device_id))
            <tr>
                <td>Device ID</td>

                <td>
                  {{$device_id ?? ''}}
                </td>
            </tr>
            @endif
            
            <tr>
                <td>Trip ID</td>
                <td>{{$trip_id ?? ''}}</td>
            </tr>
        </table>
    </div>
    <div style="overflow-x:auto;">
        <table>
            <tr>
                <td colspan="3" style="color: black;font-weight:700;">Driver Summary</td>
            </tr>
            <tr>
                <td>Driver Name:{{ $device_summary->container_details->driver_name ??''}} </td>
                <td>Container No:{{$device_summary->container_details->container_no ??''}}</td>
                <td>Vehicle No:{{$device_summary->container_details->vehicle_no ??''}}</td>
            </tr>
            <tr>
                <td>License No: {{$device_summary->container_details->license_no ??''}}</td>
                <td>Id Proof No:{{$device_summary->container_details->id_proof_no ??''}}</td>
                <td>Mobile No:{{$device_summary->container_details->mobile_no ??''}}</td>
            </tr>
            <tr>
                <td>Co Driver Name: {{$device_summary->container_details->co_driver_name ??''}}</td>
                <td>Co Driver License No:{{$device_summary->container_details->co_driver_license_no ??''}}</td>
                <td>Co Drive Id Proof No: {{$device_summary->container_details->co_drive_id_proof_no ??''}}</td>    
            </tr>
        </table>
    </div>
    <div style="overflow-x:auto;" >
        <table>
            <tr>
                <td colspan="3" style="color: black;font-weight:700;">Trip Summary</td>
            </tr>
            <tr>
                <td>Device ID:{{$device_summary->device_id ??''}}</td>
                <td>Trips ID:{{$device_summary->trip_id ??''}}</td>
                <td>From Destination:{{$device_summary->from_location_name ??''}}</td>
            </tr>
            <tr>
                <td>To Destination:{{$device_summary->to_location_name ??''}}</td>
                <td>Cargo Type:{{$device_summary->shipping_details->cargo_type ??''}}</td>
                <td>GST No:{{$device_summary->gstno ??''}}</td>
            </tr>
            <tr>
                <td>Start Date :{{$device_summary->trip_start_date ??''}}</td>
                <td>Expected Date:{{$device_summary->expected_arrival_time ??''}}</td>
                <td>Completed Date:{{$device_summary->completed_trip_time ??''}}</td>    
            </tr>
        </table>
    </div>
    <div style="overflow-x:auto;" >
        <table>
            <tr>
                <td colspan="3" style="color: black;font-weight:700;">Shipping Details</td>
            </tr>
            <tr>
                <td>Invoice No:{{$device_summary->shipping_details->invoice_no ??''}}</td>
                <td>Invoice Date:{{$device_summary->shipping_details->invoice_date ??''}}</td>
                <td>Customer CIF INR:{{$device_summary->shipping_details->customer_cif_inr ??''}}</td>
            </tr>
            <tr>
                <td>E Way Bill No:{{$device_summary->shipping_details->e_way_bill_no ??''}}</td>
                <td>Shipping Details:{{$device_summary->shipping_details->shipping_details ??''}}</td>
                <td>Exporter Details:{{$device_summary->shipping_details->exporter_details ??''}}</td>
            </tr>
            <tr>
                <td>Start Date :{{$device_summary->trip_start_date ??''}}</td>
                <td>Expected Date:{{$device_summary->expected_arrival_time ??''}}</td>
                <td>Cargo Type:{{$device_summary->shipping_details->cargo_type ??''}}</td>
            </tr>
            <tr>
                <td>Shipment Type:{{$device_summary->shipping_details->shipment_type ??''}}</td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>
    <div >
        <table >
            <tr>
                <td colspan="3" style="color: black;font-weight:700;">Documents</td>
            </tr>
            <tr>
                @if(isset($device_summary->invoice_bill) && !empty($device_summary->invoice_bill)) 
                <td>Invoice Bill:<span style="color: blue;word-break: break-all;">{{asset('invoice_bill/'.$device_summary->invoice_bill)}}</span></td>
                @else
                  <td>Invoice Bill: </td>
                @endif

                @if(isset($device_summary->custom_unexture_a) && !empty($device_summary->custom_unexture_a))
                <td>Custom Unexture-A:<span style="color: blue;word-break: break-all;">{{asset('unexture_a/'.$device_summary->custom_unexture_a) }}</span></td>
                @else
                <td >Custom Unexture-A: </td>
                @endif

                @if(isset($device_summary->custom_unexture_b) && !empty($device_summary->custom_unexture_b)) 
                <td>Custom Unexture-B:<span style="color: blue;word-break: break-all;">{{ asset('unexture_b/'.$device_summary->custom_unexture_b)}}</span></td>
                @else
                <td>Custom Unexture-B:</td>
                @endif
            </tr>
        </table>
    </div>

    {{-- Added 16/01 --}}
    <div>
        <table>
            <tr>
                <td colspan="12" style="color: black;font-weight:700; width: 100%;">Alarm Reports</td>  
            </tr>
            <tr>
                <th style="font-size: 10px;">Sr No</th>
                <th style="font-size: 10px;">Trip ID</th>
                <th style="font-size: 10px;">Rf Id Card Number</th>
                <th style="font-size: 10px;">Alarm Title</th>
                {{-- <th style="font-size: 10px;">Cargo Type</th> --}}
                <th style="font-size: 10px;">Shipment Type</th>
                <th style="font-size: 10px;">Location</th>
                <th style="font-size: 10px;">Current Address</th>
                <th style="font-size: 10px;">Latitude</th>
                <th style="font-size: 10px;">Longitude</th>
                <th style="font-size: 10px;">Driver Name</th>
                <th style="font-size: 10px;">Vehicle No</th>
                <th style="font-size: 10px;">Contact No</th>
                <th style="font-size: 10px;">Alarm Date</th>
                {{-- <th style="font-size: 10px;">Created Date</th> --}}
            </tr>
            @forelse($alarms as $i => $log)
            <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{$log->trip_id ?? ''}}</td>
                    <td>{{$log->rfid_card_number ?? ''}}</td>

                    <td>{{ $log->alert_title ?? ''}}/{{ $log->alert_naration ?? ''}}</td>

                    @php
                        $shippingDetail = json_decode($log->shipping_detail, true);
                    @endphp
                    {{-- <td>{{$shippingDetail['cargo_type'] ?? ''}}</td> --}}
                    <td>{{$shippingDetail['shipment_type'] ?? ''}}</td>
                    <td> 
                        {{$log->from_location_name ?? ''}}-{{$log->to_location_name ?? ''}}
                    </td>

                    <td> 
                        {{$log->address ?? ''}}
                    </td>

                    <td> 
                        {{$log->latitude ?? ''}}
                    </td>

                    <td> 
                        {{$log->longitude ?? ''}}
                    </td>

                    @php
                       $container_details = json_decode($log->container_detail, true);
                    @endphp
                    <td>
                        {{$container_details['driver_name'] ?? ''}}
                    </td>
                    <td>
                        {{$container_details['vehicle_no'] ?? ''}}
                    </td>
                    <td>
                        {{$container_details['mobile_no'] ?? ''}}
                    </td>
                    <td>
                        @if(!empty($log->time))
                            <?php
                            $utcDateTime = \Carbon\Carbon::parse($log->time, 'UTC');
                            $istDateTime = $utcDateTime->setTimezone('Asia/Kolkata')->format('d-m-Y H:i:s');
                            ?>
                            {{ $istDateTime }}
                        @else
                            {{ '' }}
                        @endif
                    </td>                        
                    {{-- <td>{{ date("d-m-Y H:i:s", strtotime($log->created_at)) ?? ''}}</td> --}}
                </tr>
                @empty
                    <tr>
                        <td></td>
                        <td></td>  
                        <td></td>
                        <td></td> 
                        <td></td> 
                        <td class="text-muted" >{{ __($emptyMessage) }}</td>
                        <td></td>
                        <td></td>  
                        <td></td>
                        <td></td>  
                        <td></td>
                    </tr>
            
                @endforelse
                
            </table>
    </div>
    <div>
        <table>
            <tr>
                <td colspan="12" style="color: black;font-weight:700; width: 100%;">Events Reports</td>  
            </tr>
            <tr>
                <th style="font-size: 10px;">Sr No</th>
                <th style="font-size: 10px;">Trip ID</th>
                <th style="font-size: 10px;">Rf Id Card Number</th>
                <th style="font-size: 10px;">Events</th>
                {{-- <th style="font-size: 10px;">Cargo Type</th> --}}
                <th style="font-size: 10px;">Shipment Type</th>
                <th style="font-size: 10px;">Location</th>
                <th style="font-size: 10px;">Current Address</th>
                <th style="font-size: 10px;">Latitude</th>
                <th style="font-size: 10px;">Longitude</th>
                <th style="font-size: 10px;">Driver Name</th>
                <th style="font-size: 10px;">Vehicle No</th>
                <th style="font-size: 10px;">Contact No</th>
                <th style="font-size: 10px;">Events Date</th>
                {{-- <th style="font-size: 10px;">Created Date</th> --}}

            </tr>
            @forelse($events as $i => $log)
                
            <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{$log->trip_id ?? ''}}</td>
                    <td>{{$log->rfid_card_number ?? ''}}</td>
                    <td>{{ $log->alert_title ?? ''}}/{{$log->alert_naration ?? ''}}</td>
                    @php
                        $shippingDetail = json_decode($log->shipping_detail, true);
                    @endphp
                    {{-- <td>{{$shippingDetail['cargo_type'] ?? ''}}</td> --}}
                    <td>{{$shippingDetail['shipment_type'] ?? ''}}</td>
                    <td> 
                        {{$log->from_location_name ?? ''}}-{{$log->to_location_name ?? ''}}
                    </td>
                    <td> 
                        {{$log->address ?? ''}}
                    </td>

                    <td> 
                        {{$log->latitude ?? ''}}
                    </td>

                    <td> 
                        {{$log->longitude ?? ''}}
                    </td>

                    @php
                       $container_details = json_decode($log->container_detail, true);
                    @endphp
                    <td>
                        {{$container_details['driver_name'] ?? ''}}
                    </td>
                    <td>
                        {{$container_details['vehicle_no'] ?? ''}}
                    </td>
                    <td>
                        {{$container_details['mobile_no'] ?? ''}}
                    </td>
                    <td>{{ $log->time ?? ''}}</td>
                    {{-- <td>{{ $log->created_at ?? ''}}</td> --}}

                </tr>
                @empty
                    <tr>
                        <td></td>
                        <td></td>  
                        <td></td>
                        <td></td> 
                        <td></td> 
                        <td></td>
                        <td class="text-muted" >{{ __($emptyMessage) }}</td>
                        <td></td>  
                        <td></td>
                        <td></td>  
                        <td></td>
                        <td></td>  
                        <td></td>
                    </tr>
            
                @endforelse

            
        </table>
    </div>

</body>
</html>