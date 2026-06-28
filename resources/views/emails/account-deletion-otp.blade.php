<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Deletion - Verification Code</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #fef2f2;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            border: 1px solid #fee2e2;
        }
        .header {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            padding: 40px 20px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .content {
            padding: 40px 30px;
            text-align: center;
        }
        .content p {
            font-size: 16px;
            line-height: 24px;
            color: #4b5563;
            margin-bottom: 30px;
        }
        .otp-container {
            background-color: #fef2f2;
            border: 2px dashed #f87171;
            border-radius: 12px;
            padding: 20px;
            display: inline-block;
            margin-bottom: 30px;
        }
        .otp-code {
            font-size: 36px;
            font-weight: 800;
            color: #991b1b;
            letter-spacing: 8px;
            font-family: 'Courier New', Courier, monospace;
        }
        .footer {
            background-color: #fdf2f2;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #9ca3af;
            border-top: 1px solid #fee2e2;
        }
        .warning-box {
            background-color: #fff1f1;
            border-left: 4px solid #ef4444;
            padding: 15px;
            margin: 20px 0;
            text-align: left;
            font-size: 14px;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Account Deletion Request</h1>
        </div>
        <div class="content">
            <p>Verification code to delete your account at <strong>{{ config('app.name') }}</strong>:</p>
            
            <div class="otp-container">
                <span class="otp-code">{{ $otp }}</span>
            </div>
            
            <div class="warning-box">
                <strong>Attention:</strong> This is a permanent action. All your data, bookings, and profile information will be permanently removed.
            </div>
            
            <p>This code is valid for <strong>10 minutes</strong>. If you did not request this deletion, please ignore this email and secure your account.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
