<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Trip Email</title>
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
            <br>We hope this email finds you well. We wanted to express our sincere gratitude for choosing journey.<br>

            <br>Here's a quick recap of your trip details.<br>

            <br><strong>Trip ID:</strong> {{ $trip_id }}<br>
            <strong>Trip Start Date:</strong> {{ $trip_start_date }}<br>
            <strong>From Location Point:</strong> {{ $from_location_point }} <br>
            <strong>To Location Point:</strong> {{ $to_location_point }} <br>
            <strong>Mode of Transportation:</strong> {{ $mode_of_transportation }}<br>
            <br>For more details, please find the attached trip summary. If you have any concerns regarding the trip,
            please write to us at <a href="mailto:support@gpspackseal.in">support@gpspackseal.in</a>.<br>
            <br>Safe travels!<br>
            <br>Best regards,<br>{{ $company_name }}<br>{{ $mobile_no }}
        </p>

        <div class="contact-info">
            For any inquiries, please contact us at <a href="mailto:support@gpspackseal.in">support@gpspackseal.in</a>.
            <br><br>
        </div>
    </div>
</body>

</html>
