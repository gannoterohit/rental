<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f7f9;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f4f7f9;
            padding-bottom: 40px;
        }
        .main {
            background-color: #ffffff;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            border-spacing: 0;
            font-family: sans-serif;
            color: #4a4a4a;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            padding: 40px 20px;
            text-align: center;
        }
        .logo {
            font-size: 28px;
            font-weight: 800;
            color: #ffffff;
            text-decoration: none;
            letter-spacing: -1px;
        }
        .content {
            padding: 40px 30px;
            line-height: 1.6;
        }
        .content h2 {
            color: #1a202c;
            font-size: 24px;
            font-weight: 700;
            margin-top: 0;
            margin-bottom: 20px;
        }
        .content p {
            margin-bottom: 20px;
            font-size: 16px;
            color: #4a5568;
        }
        .footer {
            padding: 30px;
            text-align: center;
            background-color: #f8fafc;
            border-top: 1px solid #edf2f7;
        }
        .footer p {
            font-size: 12px;
            color: #718096;
            margin: 5px 0;
        }
        .btn {
            display: inline-block;
            padding: 14px 28px;
            background-color: #3b82f6;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .badge-success { background-color: #d1fae5; color: #065f46; }
        .badge-error { background-color: #fee2e2; color: #991b1b; }
        
        /* Responsive */
        @media only screen and (max-width: 600px) {
            .main {
                width: 95% !important;
            }
        }
    </style>
</head>
<body>
    <center class="wrapper">
        <table class="main" width="100%">
            <!-- Header -->
            <tr>
                <td class="header">
                    <a href="{{ config('app.url') }}" class="logo">{{ config('app.name') }}</a>
                </td>
            </tr>
            
            <!-- Body -->
            <tr>
                <td class="content">
                    @yield('content')
                </td>
            </tr>
            
            <!-- Footer -->
            <tr>
                <td class="footer">
                    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                    <p>MP Nagar, Zone 1, Bhopal, MP, India</p>
                    <p>
                        <a href="{{ config('app.url') }}/privacy-policy" style="color: #718096; text-decoration: underline;">Privacy Policy</a> | 
                        <a href="{{ config('app.url') }}/contact-us" style="color: #718096; text-decoration: underline;">Contact Support</a>
                    </p>
                </td>
            </tr>
        </table>
    </center>
</body>
</html>
