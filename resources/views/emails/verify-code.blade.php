<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Verification Code</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #000000;
            margin: 0;
            padding: 20px;
            color: #FFFFFF;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #1f1f1f;
            border-radius: 16px;
            padding: 40px;
            border: 1px solid #333333;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .logo {
            width: 48px;
            height: 48px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #9333EA, #7C3AED);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }
        .title {
            font-size: 28px;
            font-weight: 700;
            color: #FFFFFF;
            margin-bottom: 16px;
        }
        .subtitle {
            font-size: 16px;
            color: #9CA3AF;
            margin-bottom: 40px;
        }
        .code-container {
            background-color: #2a2a2a;
            border: 1px solid #404040;
            border-radius: 12px;
            padding: 32px;
            text-align: center;
            margin: 40px 0;
        }
        .code-label {
            font-size: 14px;
            color: #9CA3AF;
            margin-bottom: 16px;
        }
        .code {
            font-size: 36px;
            font-weight: 700;
            color: #FFFFFF;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
            background: linear-gradient(135deg, #9333EA, #7C3AED);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .message {
            font-size: 16px;
            color: #9CA3AF;
            line-height: 1.6;
            margin-bottom: 40px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #666666;
            border-top: 1px solid #333333;
            padding-top: 20px;
        }
        .warning {
            background-color: #2a2a2a;
            border: 1px solid #404040;
            border-radius: 8px;
            padding: 16px;
            margin: 20px 0;
            font-size: 14px;
            color: #9CA3AF;
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
            <p>Hello {{ $user->name }},</p>
            <p>Thank you for registering! To complete your account setup, please enter the verification code above in the registration form.</p>
        </div>

        <div class="message">
            <p>After verification, you can login using your email and the password you set during registration.</p>
            <p>This verification code will expire in 15 minutes for security reasons.</p>
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
