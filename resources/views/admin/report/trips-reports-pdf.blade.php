<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $general->siteName('Trips Details') }}</title>
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
            <h3>Trips Reports Details</h3>
    </div>
    <div style="overflow-x:auto;" class="transactions">
        <table>
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
                    <th style="font-size: 10px;">Device Status</th>
                    <th style="font-size: 10px;">Cargo Type</th>
                    <th style="font-size: 10px;">Shipment Type</th>
                    <th style="font-size: 10px;">Location</th>
                    <th style="font-size: 10px;">Current Address</th>
                    <th style="font-size: 10px;">Driver Name</th>
                    <th style="font-size: 10px;">Vehicle No</th>
                    <th style="font-size: 10px;">Contact No</th>
                    <th style="font-size: 10px;">Start Date</th>
                    <th style="font-size: 10px;">Exp Arrival Date</th>
                    <th style="font-size: 10px;">Trip Comp Date</th>
                    <th style="font-size: 10px;">Last Update At</th>
                    <th style="font-size: 10px;">Trip Status</th>

                </tr>
                @forelse($trips as $i => $log)
                
                    <?php
                        $trip_info = array();
                        $tc_devices = DB::table('tc_devices')->where('uniqueid', $log->device_id)->first();
                       if (isset($tc_devices) && !empty($tc_devices)) {
                          $positionid = (isset($tc_devices->positionid)) ? $tc_devices->positionid : 0;
                          if (!empty($positionid) && isset($positionid)) {
                            $tc_positions = DB::table('tc_positions')->where('id', $positionid)->first();
                           if (isset($tc_positions->attributes) && !empty($tc_positions->attributes)) {
                              $trip_info['address'] = (isset($tc_positions->address) && !empty($tc_positions->address)) ? $tc_positions->address : '';
                           }else {
                              $trip_info['address'] = '';
                           }
                               
                           }
                              
                          }
                        $device_status = (isset($tc_devices->status) && !empty($tc_devices->status)) ? $tc_devices->status : '';
                       $lastupdate = $tc_devices->lastupdate ?? '';
                      ?>
                    <tr>
                   
                        <td>{{ $i+1 }}</td>
                        <td>{{$log->trip_id ?? ''}}</td>
                        <td>{{$device_status ?? ''}}</td>
                        <td>{{$log->shipping_details->cargo_type ?? ''}}</td>
                        <td>{{$log->shipping_details->shipment_type ?? ''}}</td>
                        <td> 
                            {{$log->from_location_name ?? ''}}-{{$log->to_location_name ?? ''}}
                        </td>
                        <td>{{$log->address ?? ''}}</td>
                        <td>{{$log->container_details->driver_name}}</td>
                        <td>{{$log->container_details->vehicle_no}}</td>
                        <td>{{$log->container_details->mobile_no}}</td>
                        <td>{{$log->trip_start_date ?? ''}}</td>
                        <td>{{$log->expected_arrival_time ?? ''}}</td>
                        <td>{{$log->completed_trip_time ?? ''}}</td>
                        <td>{{$lastupdate ?? ''}}</td>
                        <td>{{$log->trip_status?? ''}}</td>
                    </tr>
                    @empty
                        <tr>
                            <td></td>
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
                            <td></td>

                        </tr>
                
                    @endforelse

                
            </table>
        </div>
    </div>
</body>
</html>