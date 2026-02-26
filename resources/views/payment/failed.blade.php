<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
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
            padding: 20px;
        }

        .container {
            max-width: 600px;
            width: 100%;
        }

        .cancel-card {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 4px 24px var(--card-shadow);
            padding: 48px 32px;
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

        .icon-container {
            width: 80px;
            height: 80px;
            margin: 0 auto 24px;
            position: relative;
        }

        .cancel-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--error-color);
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

        .cancel-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40px;
            height: 40px;
        }

        .cancel-icon path {
            stroke: white;
            stroke-width: 4;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
            stroke-dasharray: 60;
            stroke-dashoffset: 60;
            animation: drawX 0.5s ease-out 0.2s forwards;
        }

        @keyframes drawX {
            to {
                stroke-dashoffset: 0;
            }
        }

        h1 {
            color: var(--text);
            font-size: 32px;
            margin-bottom: 12px;
            font-weight: 700;
        }

        .message {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .details {
            background: #fff5f5;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 32px;
            border: 1px solid #fecaca;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #666;
            font-size: 14px;
            font-weight: 500;
        }

        .detail-value {
            color: var(--text);
            font-size: 16px;
            font-weight: 600;
        }

        .status {
            color: var(--error-color);
            font-weight: 700;
        }

        .info-box {
            background: var(--highlight);
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 32px;
            border-left: 4px solid var(--primary);
            text-align: left;
        }

        .info-box-title {
            font-weight: 600;
            color: var(--text);
            margin-bottom: 8px;
            font-size: 15px;
        }

        .info-box-text {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
        }

        .buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            flex: 1;
            min-width: 140px;
            padding: 14px 28px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
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
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #eee;
            font-size: 13px;
            color: #999;
        }

        @media (max-width: 480px) {
            .cancel-card {
                padding: 32px 24px;
            }

            h1 {
                font-size: 26px;
            }

            .buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="cancel-card">
            <div class="icon-container">
                <div class="cancel-circle">
                    <svg class="cancel-icon" viewBox="0 0 52 52">
                        <path d="M16 16 L36 36 M36 16 L16 36"/>
                    </svg>
                </div>
            </div>

            <h1>Payment Failed</h1>
            <p class="message">
                Your payment has been failed.
            </p>

            <div class="details">
                <div class="detail-row">
                    <span class="detail-label">Reference ID</span>
                    <span class="detail-value">REF-2024-0012345</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Date & Time</span>
                    <span class="detail-value">Nov 07, 2025 at 2:45 PM</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status</span>
                    <span class="detail-value status">Failed</span>
                </div>
            </div>

            <div class="info-box">
                <div class="info-box-title">What happens next?</div>
                <div class="info-box-text">
                    Your payment was not processed. You can try again or contact our support team if you need assistance.
                </div>
            </div>

            <div class="buttons">
                <button class="btn btn-primary" >
                    Try Again
                </button>
                <button class="btn btn-secondary" >
                    Return to Home
                </button>
            </div>

        </div>
    </div>
</body>
</html>