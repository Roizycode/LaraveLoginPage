<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #D8D8F6 0%, #E8E8F8 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo {
            font-size: 32px;
            font-weight: 700;
            color: #4A4A8A;
            margin-bottom: 10px;
        }
        
        .title {
            font-size: 24px;
            font-weight: 600;
            color: #2D2D2D;
            margin-bottom: 20px;
        }
        
        .content {
            color: #555;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        .verify-button {
            display: inline-block;
            background: #4A4A8A;
            color: white;
            padding: 16px 32px;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            text-align: center;
            margin: 20px 0;
            transition: all 0.3s ease;
        }
        
        .verify-button:hover {
            background: #3A3A7A;
            transform: translateY(-2px);
        }
        
        .footer {
            text-align: center;
            color: #888;
            font-size: 14px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        .security-note {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #4A4A8A;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">Welcome!</div>
            <h1 class="title">Verify Your Email Address</h1>
        </div>
        
        <div class="content">
            <p>Hello {{ $user->name }},</p>
            
            <p>Thank you for registering with us! To complete your account setup and start using our services, please verify your email address by clicking the button below:</p>
            
            <div style="text-align: center;">
                <a href="{{ $verificationUrl }}" class="verify-button">Verify Email Address</a>
            </div>
            
            <p>If the button doesn't work, you can also copy and paste this link into your browser:</p>
            <p style="word-break: break-all; background: #f5f5f5; padding: 10px; border-radius: 5px; font-family: monospace;">
                {{ $verificationUrl }}
            </p>
            
            <div class="security-note">
                <strong>Security Note:</strong> This verification link will expire in 24 hours for security reasons. If you didn't create an account with us, please ignore this email.
            </div>
            
            <p>Once verified, you'll be able to:</p>
            <ul>
                <li>Access your account dashboard</li>
                <li>Use all our features and services</li>
                <li>Receive important updates and notifications</li>
            </ul>
        </div>
        
        <div class="footer">
            <p>If you're having trouble with the button above, copy and paste the URL below into your web browser.</p>
            <p>This email was sent to {{ $user->email }}. If you didn't request this, please ignore this email.</p>
            <p>&copy; {{ date('Y') }} Your App Name. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
