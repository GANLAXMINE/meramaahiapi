<!DOCTYPE html>
<html>

<head>
    <title>Payment Action Required Notification</title>
</head>

<body>
    <h2>Payment Action Required Notification</h2>
    <p>Dear customer,</p>
    <p>Your action is required for invoice #{{ $invoice_id }}.</p>
    <p>Please proceed to complete the necessary steps for payment.</p>
    <p>You can view the full invoice <a href="{{ $invoice_url }}">here</a>.</p>
    <p>Thank you.</p>
</body>

</html>