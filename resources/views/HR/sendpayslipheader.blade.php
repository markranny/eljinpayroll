<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
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
        h1 {
            text-align: center;
            color: #333;
        }
        .payroll-info {
            margin-bottom: 20px;
            text-align: center;
        }
        .payroll-info p {
            margin: 5px 0;
            font-size: 16px;
            font-weight: bold;
        }
        .quote {
            margin-top: 20px;
            text-align: center;
            font-style: italic;
            color: #666;
        }
        .disclaimer {
            margin-top: 20px;
            font-size: 12px;
            color: #999;
            text-align: center;
        }
    </style>
</head>
<body>
@foreach ($payslip as $data)
    <div class="container">
        <h1>{{$data->employee_name}}</h1>
        <p style="text-align: center;">This is your payslip for below payroll:</p>
        <div class="payroll-info">
            <p>PAYROLL DATE: {{$data->month}}-{{$data->year}} / {{$data->period}}</p>
        </div>
        <p class="quote">“EARN NICELY, SPEND WISELY AND YOU WILL LIVE HAPPILY!”</p>
        <p class="disclaimer">THIS IS A SYSTEM-GENERATED REPORT, NO SIGNATURE IS REQUIRED.<br>THIS IS AN AUTOMATED EMAIL DO NOT REPLY.</p>
    </div>
    @endforeach
</body>
</html>