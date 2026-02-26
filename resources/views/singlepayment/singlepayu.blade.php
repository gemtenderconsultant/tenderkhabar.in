<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayU Payment Form</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); */
            padding: 30px 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }
        /* Background Shapes */
        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            top: -250px;
            right: -150px;
            z-index: 0;
        }
        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            bottom: -200px;
            left: -100px;
            z-index: 0;
        }
        .shape-1 {
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(224, 178, 35, 0.1);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            top: 50%;
            left: -100px;
            transform: translateY(-50%) rotate(45deg);
            z-index: 0;
        }
        .shape-2 {
            position: absolute;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 63% 37% 54% 46% / 55% 48% 52% 45%;
            bottom: 10%;
            right: 10%;
            z-index: 0;
        }
        .shape-3 {
            position: absolute;
            width: 150px;
            height: 150px;
            border: 3px solid rgba(224, 178, 35, 0.2);
            border-radius: 50%;
            top: 15%;
            right: 15%;
            z-index: 0;
        }
        .payment-form {
            max-width: 750px;
            width: 100%;
            background: #fff;
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        .payment-form::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #E0B223 0%, #f59e0b 100%);
        }
        .logo-container {
            text-align: center;
            margin-bottom: 15px;
        }
        .logo-img {
            height: 40px;
            max-width: 100%;
        }
        .payment-form h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #1e3a8a;
            font-size: 22px;
            font-weight: 700;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 12px;
        }
        .form-group {
            margin-bottom: 12px;
        }
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        .payment-form label {
            color: #1e3a8a;
            font-weight: 600;
            font-size: 13px;
            display: block;
            margin-bottom: 5px;
        }
        .payment-form input {
            width: 100%;
            padding: 11px 13px;
            border-radius: 6px;
            font-size: 14px;
            border: 2px solid #e2e8f0;
            background: #f8fafc;
            transition: all 0.3s ease;
        }
        .payment-form input:focus {
            outline: none;
            border-color: #E0B223;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(224, 178, 35, 0.1);
        }
        .payment-form input[readonly] {
            border: 1px solid #E0B223;
            color: #1e3a8a;
            font-weight: 700;
            cursor: not-allowed;
            background: #fff9e6;
        }
        .payment-form button {
            width: 100%;
            padding: 13px;
            margin-top: 10px;
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            color: #fff;
            border: none;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 6px;
        }
        .payment-form button:hover {
            background: linear-gradient(135deg, #152d6e 0%, #1e3a8a 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(30, 58, 138, 0.4);
        }
        .payment-form button:active {
            transform: translateY(0);
        }

        @media screen and (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .payment-form {
                padding: 22px 25px;
            }
            .payment-form h2 {
                font-size: 20px;
            }
        }

        @media screen and (max-width: 640px) {
            body {
                padding: 20px 15px;
            }
            .payment-form {
                padding: 20px;
                border-radius: 10px;
            }
            .payment-form h2 {
                font-size: 18px;
                margin-bottom: 15px;
            }
            .logo-img {
                height: 35px;
            }
            .form-group {
                margin-bottom: 10px;
            }
            .form-row {
                gap: 10px;
                margin-bottom: 10px;
            }
            .payment-form label {
                font-size: 12px;
            }
            .payment-form input {
                padding: 10px 11px;
                font-size: 13px;
            }
            .payment-form button {
                font-size: 14px;
                padding: 12px;
            }
        }

        @media screen and (max-width: 480px) {
            body {
                padding: 15px 10px;
            }
            .payment-form {
                padding: 18px;
                max-width: 100%;
            }
            .payment-form h2 {
                font-size: 17px;
            }
            .logo-img {
                height: 32px;
            }
        }

        @media screen and (max-width: 360px) {
            .payment-form {
                padding: 16px;
            }
            .payment-form h2 {
                font-size: 16px;
                margin-bottom: 12px;
            }
            .logo-img {
                height: 28px;
            }
            .form-group {
                margin-bottom: 8px;
            }
            .payment-form input {
                padding: 9px 10px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="shape-1"></div>
    <div class="shape-2"></div>
    <div class="shape-3"></div>

    <div class="payment-form">
        <div class="logo-container">
            <img src="{{ asset('assets/img/Logo Image 1 - Copy.jpg') }}" alt="Logo" class="logo-img" />
        </div>

        <form method="POST" action="{{ route('singlepayu.pay') }}">
            @csrf
            <input type="hidden" name="signature" value="{{ $signature }}">
            <input type="hidden" name="tenderid" id="tenderid" value="{{ $tenderid }}">
            <div class="form-row">
                <div class="form-group">
                    <label>Plan</label>
                    <input type="text" name="plan_name" value="{{ $plan }}" id="plan_name" readonly>
                </div>

                <div class="form-group">
                    <label>Amount</label>
                    <input type="text" name="amount" id="amount" value="{{ $amount }}" readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" required>
                </div>

                <div class="form-group">
                    <label>Company Name</label>
                    <input type="text" name="cname" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>GST Number</label>
                    <input type="text" name="gst" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" required>
            </div>

            <button type="submit">Buy Now</button>
        </form>
    </div>
</body>
</html>