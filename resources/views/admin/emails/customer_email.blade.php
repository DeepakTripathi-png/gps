

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Email</title>
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
            /* background-color: #3498db;
            color: #fff; */
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        p {
            line-height: 1.6;
            color: #333;
        }

        .details {
            margin-bottom: 20px;
        }

        /* .details strong {
            color: #3498db;
        } */

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
        <p class="has-background">Dear {{ $customer_name }},<br>
            <br>Thank you for signing up. We’re excited to have you on board. Here are your account details:&nbsp;<br>
            <br><strong>Username:</strong> {{ $username }}<br>
            <strong>Password:</strong> {{ $password }}&nbsp;<br>
            <br>You needn’t do anything at this point. Make sure to save this email for future reference.<br>
            <br>Thank you for once again registering. In case of any questions, contact support at <a
                href="mailto:support@gpspackseal.in ">support@gpspackseal.in </a>.&nbsp;<br>
            <br>Best regards,<br>Team,<br>Packseal Industries
        </p>

        <div class="contact-info">
            For any inquiries, please contact us at <a href="mailto:support@gpspackseal.in ">support@gpspackseal.in </a>.
        </div>
    </div>
</body>

</html>
