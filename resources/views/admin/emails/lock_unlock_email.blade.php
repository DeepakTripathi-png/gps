<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
         body {
            font-family: "Poppins", sans-serif;
            text-align: left;
            font-size: 11px; 
        }
        .transactions table {
            width: 25%; 
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

    </style>
</head>
<body>
    <h4>Dear Sir,</h4> 
    <p style="margin-left: 2%;">Alert generated please go through Below Details.</p>
    <div class="transactions">
        <table>
            <tr>
                <td style="width: 25%;">Trip ID</td>
                <td><?php echo "1";?></td>
            </tr>
            <tr>
                <td style="width: 25%;">From Location</td>
                <td><?php echo "1";?></td>
            </tr>
            <tr>
                <td style="width: 25%;">To Location</td>
                <td><?php echo "1";?></td>
            </tr>
            <tr>
                <td style="width: 25%;">Container No</td>
                <td><?php echo "1";?></td>
            </tr>
            <tr>
                <td style="width: 25%;">Vehicale No</td>
                <td><?php echo "1";?></td>
            </tr>
            <tr>
                <td style="width: 25%;">Driver Name</td>
                <td><?php echo "1";?></td>
            </tr>
            <tr>
                <td style="width: 25%;">Exporter ID</td>
                <td><?php echo "1";?></td>
            </tr>
            <tr>
                <td style="width: 25%;">Address</td>
                <td><?php echo "1";?></td>
            </tr>
        </table>
    </div>
    <h4>Thank You</h4> 

</body>
</html>
