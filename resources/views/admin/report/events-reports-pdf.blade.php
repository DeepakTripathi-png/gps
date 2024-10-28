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
            <h3>Events Reports Details</h3>
    </div>
    <div style="overflow-x:auto;" class="transactions">
        <table>
            <tr>
                <td>Device ID</td>

                <td>
                  {{$device_id ?? ''}}
                </td>
            </tr>
            <tr>
                <td>Trip ID</td>
                <td>{{$trip_id ?? ''}}</td>
            </tr>
            <tr>
                <td>From Date</td>
                <td>{{$dateRange ?? ''}}</td>
            </tr>
        </table>
    </div>

    <div class="center-container">
        <div>
            <table>
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
    </div>
</body>
</html>