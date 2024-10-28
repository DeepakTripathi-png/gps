<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alarm Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .has-background {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            /* background-color: #3498db; */
            /* color: #fff; */
        }

        p {
            line-height: 1.6;
            color: #333;
        }

        .details {
            margin-bottom: 20px;
        }

        .details strong {
            color: #3498db;
        }

        .contact-info {
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <p class="has-background">Dear User/Officer,<br>
            <br>This is an automated notification to inform you that an alarm has been triggered  <strong>{{ $type }}.</strong> 
            Please take immediate action to investigate and resolve the issue.<br>

            <br>Alarm Details.<br>

            <br><strong>Trip ID:</strong> {{ $trip_id }}<br>
            <strong>Alarm Type:</strong> {{ $type }}<br>
            <strong>Triggered at:</strong> {{ $created_at }} <br>
            <strong>Location:</strong> {{ $address }} <br>
            <strong>Latitude:</strong> {{ $latitude }} <br>
            <strong>Longitude:</strong> {{ $longitude }} <br>
            <strong>Description:</strong> {{ $alert_naration }}<br>

            <br>Thank you for your prompt attention to this matter.<br>
            <br>Sincerely,<br>{{ $company_name }}
        </p>
    </div>
</body>

</html>
