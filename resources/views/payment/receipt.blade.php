<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; }
        .header { text-align: center; margin-bottom: 20px; }
        .details { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .details td { padding: 8px; border-bottom: 1px solid #eee; }
        .footer { text-align: center; font-size: 12px; margin-top: 30px; color: #777; }
        .amount { font-size: 20px; font-weight: bold; color: #1e3a8a; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <h2>Payment Receipt</h2>
            <p><strong>Aarav Tender Consultant Pvt. Ltd.</strong></p>
        </div>

        <table class="details">
            <tr><td><strong>Transaction ID:</strong></td><td>{{ $data['txnid'] }}</td></tr>
            <tr><td><strong>Customer Name:</strong></td><td>{{ $data['name'] }}</td></tr>
            <tr><td><strong>Company Name:</strong></td><td>{{ $data['cname'] }}</td></tr>
            <tr><td><strong>Email:</strong></td><td>{{ $data['email'] }}</td></tr>
            <tr><td><strong>Plan:</strong></td><td>{{ $data['plan'] }}</td></tr>
            <tr><td><strong>Date:</strong></td><td>{{ $data['date'] }}</td></tr>
            <tr>
                <td><strong>Total Amount Paid:</strong></td>
                <td class="amount">{{ $data['amount'] }}</td>
            </tr>
        </table>

        <div class="footer">
            <p>This is a computer-generated receipt and does not require a signature.</p>
            <p>Thank you for choosing TenderKhabar.</p>
        </div>
    </div>
</body>
</html>