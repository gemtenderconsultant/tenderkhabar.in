<!DOCTYPE html>
<html>
<head>
    <title>Payment Success</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <h2>New Payment Received!</h2>
    <p>A new transaction has been completed successfully via PayU.</p>
    
    <table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
        <tr><td><strong>Plan:</strong></td><td>{{ $details['plan'] }}</td></tr>
        <tr><td><strong>Amount:</strong></td><td>₹{{ $details['amount'] }}</td></tr>
        <tr><td><strong>Customer Name:</strong></td><td>{{ $details['name'] }}</td></tr>
        <tr><td><strong>Email:</strong></td><td>{{ $details['email'] }}</td></tr>
        <tr><td><strong>Phone:</strong></td><td>{{ $details['phone'] }}</td></tr>
        <tr><td><strong>Company Name:</strong></td><td>{{ $details['cname'] }}</td></tr>
        <tr><td><strong>GST Number:</strong></td><td>{{ $details['gst'] }}</td></tr>
        <tr><td><strong>Transaction ID:</strong></td><td>{{ $details['txnid'] }}</td></tr>
        <tr><td><strong>PayU ID:</strong></td><td>{{ $details['payuid'] }}</td></tr>
    </table>

    <p>Regards,<br>TenderKhabar System</p>
</body>
</html>