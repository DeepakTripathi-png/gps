@php
    use Carbon\Carbon;
@endphp
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
            <h3>Route Trips Details</h3>
    </div>
    <div style="overflow-x:auto;" class="transactions">
        <table>
            <tr>
                <td>Trip ID</td>
                <td>{{$trip_id ?? ''}}</td>
            </tr>
            {{-- <tr>
                <td>From Date</td>
                <td>{{$dateRange ?? ''}}</td>
            </tr> --}}
        </table>
    </div>

    <div class="center-container">
        <div>
            <table>
                <tr>
                    <th style="font-size: 10px;">Sr No</th>
                    <th style="font-size: 10px;">Device ID</th>
                    <th style="font-size: 10px;width:90px;">Date</th>
                    <th style="font-size: 10px;">Latitude</th>
                    <th style="font-size: 10px;">Longitude</th>
                    <th style="font-size: 10px;">Speed</th>
                    <th style="font-size: 10px;">Current address</th>
                </tr>
                @forelse($getdata  as $i => $log)

                @php
                $devicetime = $log->devicetime ?? '';
                $adjusted_time = Carbon::parse($devicetime)->addHours(5)->addMinutes(30);
                $adjusted_time_format = date('Y-m-d H:i:s',strtotime($adjusted_time));

                @endphp
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{$device_id ?? ''}}</td>
                        <td>{{$adjusted_time_format ?? ''}}</td>
                        <td>{{$log->latitude ?? ''}}</td>
                        <td>{{$log->longitude ?? ''}}</td>
                        <td>{{ $log->speed ?? ''}}</td>
                        <td>{{$log->address ?? ''}}</td>
                    </tr>
                    @empty
                        <tr>
                            <td></td> 
                            <td></td>
                            <td></td>  
                            <td class="text-muted text-right" >{{ __($emptyMessage) }}</td>
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