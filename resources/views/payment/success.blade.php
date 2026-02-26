<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
        :root {
            --primary: #E0B223;
            --secondary: #1e3a8a;
            --text: #333;
            --bg: #f8f9fc;
            --card-bg: #fff;
            --card-shadow: rgba(0, 0, 0, 0.1);
            --highlight: #fff9b3;
            --highlight-shadow: rgba(245, 197, 24, 0.4);
            --error-color: #d93025;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
        }

        .container {
            max-width: 480px;
            width: 100%;
        }

        .success-card {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 4px 24px var(--card-shadow);
            padding: 32px 24px;
            text-align: center;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .checkmark-container {
            width: 60px;
            height: 60px;
            margin: 0 auto 18px;
            position: relative;
        }

        .checkmark-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary);
            position: relative;
            animation: scaleIn 0.4s ease-out;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }

        .checkmark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 28px;
            height: 28px;
        }

        .checkmark path {
            stroke: white;
            stroke-width: 4;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
            stroke-dasharray: 70;
            stroke-dashoffset: 70;
            animation: drawCheck 0.5s ease-out 0.2s forwards;
        }

        @keyframes drawCheck {
            to {
                stroke-dashoffset: 0;
            }
        }

        h1 {
            color: var(--text);
            font-size: 24px;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .message {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .details {
            background: var(--highlight);
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px var(--highlight-shadow);
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #666;
            font-size: 13px;
            font-weight: 500;
        }

        .detail-value {
            color: var(--text);
            font-size: 14px;
            font-weight: 600;
        }

        .amount {
            font-size: 18px;
            color: var(--secondary);
        }

        .buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            flex: 1;
            min-width: 120px;
            padding: 11px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: var(--secondary);
            color: white;
        }

        .btn-primary:hover {
            background: #152d6e;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
        }

        .btn-secondary {
            background: var(--card-bg);
            color: var(--text);
            border: 2px solid var(--primary);
        }

        .btn-secondary:hover {
            background: var(--highlight);
            transform: translateY(-2px);
        }

        .reference {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #999;
        }

        /* Tablet devices - 768px and below */
        @media screen and (max-width: 768px) {
            body {
                padding: 12px;
            }

            .container {
                max-width: 420px;
            }

            .success-card {
                padding: 28px 20px;
                border-radius: 10px;
            }

            .checkmark-container {
                width: 55px;
                height: 55px;
                margin-bottom: 16px;
            }

            .checkmark-circle {
                width: 55px;
                height: 55px;
            }

            .checkmark {
                width: 25px;
                height: 25px;
            }

            h1 {
                font-size: 22px;
                margin-bottom: 6px;
            }

            .message {
                font-size: 13px;
                margin-bottom: 18px;
            }

            .details {
                padding: 14px;
                margin-bottom: 18px;
            }

            .detail-row {
                padding: 7px 0;
            }

            .detail-label {
                font-size: 12px;
            }

            .detail-value {
                font-size: 13px;
            }

            .amount {
                font-size: 17px;
            }

            .btn {
                padding: 10px 18px;
                font-size: 13px;
            }
        }

        /* Mobile devices - 640px and below */
        @media screen and (max-width: 640px) {
            body {
                padding: 10px;
            }

            .success-card {
                padding: 24px 18px;
            }

            .checkmark-container {
                width: 50px;
                height: 50px;
                margin-bottom: 14px;
            }

            .checkmark-circle {
                width: 50px;
                height: 50px;
            }

            .checkmark {
                width: 22px;
                height: 22px;
            }

            h1 {
                font-size: 20px;
            }

            .message {
                font-size: 13px;
                margin-bottom: 16px;
            }

            .details {
                padding: 12px;
                margin-bottom: 16px;
            }

            .amount {
                font-size: 16px;
            }

            .reference {
                margin-top: 14px;
                padding-top: 14px;
            }
        }

        /* Small mobile devices - 480px and below */
        @media screen and (max-width: 480px) {
            body {
                padding: 8px;
                align-items: flex-start;
                padding-top: 20px;
            }

            .success-card {
                padding: 20px 16px;
            }

            .checkmark-container {
                width: 48px;
                height: 48px;
                margin-bottom: 12px;
            }

            .checkmark-circle {
                width: 48px;
                height: 48px;
            }

            .checkmark {
                width: 20px;
                height: 20px;
            }

            h1 {
                font-size: 19px;
            }

            .message {
                font-size: 12px;
                margin-bottom: 14px;
            }

            .details {
                padding: 12px;
                margin-bottom: 14px;
                border-radius: 8px;
            }

            .detail-row {
                padding: 6px 0;
            }

            .detail-label {
                font-size: 11px;
            }

            .detail-value {
                font-size: 12px;
            }

            .amount {
                font-size: 15px;
            }

            .buttons {
                flex-direction: column;
                gap: 8px;
            }

            .btn {
                width: 100%;
                min-width: unset;
                padding: 10px 16px;
                font-size: 13px;
            }

            .reference {
                margin-top: 12px;
                padding-top: 12px;
                font-size: 11px;
            }
        }

        /* Extra small devices - 360px and below */
        @media screen and (max-width: 360px) {
            body {
                padding: 6px;
                padding-top: 15px;
            }

            .success-card {
                padding: 18px 14px;
            }

            .checkmark-container {
                width: 45px;
                height: 45px;
                margin-bottom: 10px;
            }

            .checkmark-circle {
                width: 45px;
                height: 45px;
            }

            h1 {
                font-size: 18px;
            }

            .message {
                font-size: 12px;
                margin-bottom: 12px;
            }

            .details {
                padding: 10px;
                margin-bottom: 12px;
            }

            .detail-row {
                padding: 5px 0;
            }

            .btn {
                padding: 9px 14px;
                font-size: 12px;
            }
        }

        /* Landscape orientation for mobile */
        @media screen and (max-height: 600px) and (orientation: landscape) {
            body {
                padding: 10px;
                align-items: flex-start;
            }

            .success-card {
                padding: 20px 18px;
            }

            .checkmark-container {
                width: 45px;
                height: 45px;
                margin-bottom: 10px;
            }

            .checkmark-circle {
                width: 45px;
                height: 45px;
            }

            h1 {
                font-size: 18px;
                margin-bottom: 6px;
            }

            .message {
                margin-bottom: 12px;
            }

            .details {
                padding: 10px;
                margin-bottom: 12px;
            }

            .detail-row {
                padding: 5px 0;
            }

            .buttons {
                gap: 8px;
            }

            .reference {
                margin-top: 10px;
                padding-top: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-card">
            <div class="checkmark-container">
                <div class="checkmark-circle">
                    <svg class="checkmark" viewBox="0 0 52 52">
                        <path d="M14 27l7.5 7.5L38 18"/>
                    </svg>
                </div>
            </div>

            <h1>Payment Successful!</h1>
            <p class="message">Your payment has been processed successfully. Thank you for your purchase.</p>

            <div class="details">
                <div class="detail-row">
                    <span class="detail-label">Transaction ID</span>
                    <span class="detail-value">{{ request('txnid') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Plan</span>
                    <span class="detail-value">{{ request('productinfo') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Amount Paid</span>
                    <span class="detail-value amount">₹{{ request('amount') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Date</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse(request('addedon'))->format('d-m-Y h:i A') }}</span>
                </div>
            </div>

            <div class="buttons">
                <a href="https://www.tenderkhabar.in/" class="btn btn-primary">Go to Dashboard</a>
                {{-- <a href="#" class="btn btn-secondary">Download Receipt</a> --}}
                <a href="{{ route('payment.receipt', [
                    'txnid' => request('txnid'),
                    'payuid' => request('mihpayid'),
                    'name' => request('firstname'),
                    'email' => request('email'),
                    'plan' => request('productinfo'),
                    'amount' => request('amount'),
                    'cname' => request('udf1')
                ]) }}" class="btn btn-secondary">Download Receipt</a>
            </div>

            <div class="reference">
                Reference: Please save this confirmation for your records.
            </div>
        </div>
    </div>
</body>
</html>