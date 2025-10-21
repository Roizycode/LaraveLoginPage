<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Verification Code</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #000000;
            margin: 0;
            padding: 20px;
            color: #FFFFFF;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            max-width: 600px;
            width: 100%;
            background-color: #1a1a1a;
            border-radius: 16px;
            padding: 48px 40px;
            border: 1px solid #333333;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        .header {
            margin-bottom: 40px;
        }

        .logo {
            width: 48px;
            height: 48px;
            margin: 0 auto 16px;
            background: linear-gradient(135deg, #87CEEB, #ADD8E6);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            box-shadow: 0 3px 12px rgba(135, 206, 235, 0.3);
        }

        .title {
            font-size: 24px;
            font-weight: 700;
            color: #FFFFFF;
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .subtitle {
            font-size: 14px;
            color: #9CA3AF;
            margin-bottom: 0;
            font-weight: 400;
        }

        .code-container {
            background-color: #2a2a2a;
            border: 1px solid #404040;
            border-radius: 12px;
            padding: 40px 32px;
            text-align: center;
            margin: 40px 0;
        }

        .code-label {
            font-size: 14px;
            color: #9CA3AF;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .code {
            font-size: 32px;
            font-weight: 700;
            color: #FFFFFF;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
            margin: 0;
            text-shadow: 0 0 8px rgba(255, 255, 255, 0.1);
        }

        .message {
            font-size: 14px;
            color: #9CA3AF;
            line-height: 1.5;
            margin-bottom: 20px;
            text-align: left;
        }

        .message p {
            margin-bottom: 12px;
        }

        .message p:last-child {
            margin-bottom: 0;
        }

        .warning {
            background-color: #2a2a2a;
            border: 1px solid #404040;
            border-radius: 8px;
            padding: 20px;
            margin: 32px 0;
            font-size: 14px;
            color: #9CA3AF;
            text-align: left;
        }

        .warning strong {
            color: #FFFFFF;
            font-weight: 600;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #666666;
            margin-top: 32px;
            padding-top: 20px;
            border-top: 1px solid #333333;
        }

        .footer p {
            margin-bottom: 8px;
        }

        .footer p:last-child {
            margin-bottom: 0;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .container {
                margin: 10px;
                padding: 32px 24px;
            }
            
            .title {
                font-size: 28px;
            }

            .code {
                font-size: 36px;
                letter-spacing: 8px;
            }

            .logo {
                width: 56px;
                height: 56px;
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">✓</div>
            <h1 class="title">Verify Your Email</h1>
            <p class="subtitle">Enter this code to complete your registration</p>
        </div>

        <div class="code-container">
            <div class="code-label">Your verification code is:</div>
            <div class="code">{{ $verificationCode }}</div>
        </div>

        <div class="message">
            <p>Hello {{ $user->name }}. Thank you for registering! To complete your account setup, please enter the verification code above in the registration form. After verification, you can login using your email and the password you set during registration. This verification code will expire in 15 minutes for security reasons.</p>
        </div>

        <div class="warning">
            <strong>Security Notice:</strong> Never share this code with anyone. Our team will never ask for your verification code.
        </div>

        <div class="footer">
            <p>If you didn't request this code, please ignore this email.</p>
            <p>This is an automated message, please do not reply.</p>
        </div>
    </div>
</body>
</html>
