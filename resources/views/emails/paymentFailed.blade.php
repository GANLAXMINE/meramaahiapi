<!DOCTYPE html>
<html>
<head>
    <title>Payment Failed Notification</title>
</head>
<body>
    <h2>Payment Failed Notification</h2>
    <p>Dear customer,</p>
    <p>We regret to inform you that your payment for invoice #{{ $invoice_id }} has failed.</p>
    <p>Please check your payment method and try again.</p>
    <p>You can view the full invoice <a href="{{ $invoice_url }}">here</a>.</p>
    <p>Thank you.</p>
</body>
</html>
