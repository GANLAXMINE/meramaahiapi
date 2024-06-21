<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Created</title>
    <style>
        /* Reset styles */
        body,
        p {
            margin: 0;
            padding: 0;
        }

        /* Main container */
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            border-radius: 10px;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            color: #333;
        }

        /* Content */
        .content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 style="color: #007bff;">Welcome to HitoMatch - Your Subscription is Confirmed!</h1>
        </div>
        <div class="content">
            <p>Hello {{ $customerName }},</p>
            @if(isset($message) && is_string($message))
            <p>{{ $message }}</p>
            @else
            <p>Thank you for subscribing to HitoMatch! We're excited to have you on board. Your subscription is now active.</p>
            @endif
            <p>Attached to this email is your subscription invoice for your reference. You can view your subscription details and payment information by clicking the link below:</p>
            <p><a href="{{ $invoiceUrl }}" style="color: #007bff;">View Invoice</a></p>
            <p>If you have any questions or concerns, feel free to contact us at hellohitomatch@gmail.com.</p>
        </div>
        <div class="footer">
            <p>Best regards,<br> HitoMatch Team</p>
        </div>
    </div>
</body>


</html>