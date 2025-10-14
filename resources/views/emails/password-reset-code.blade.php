<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Code</title>
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
        
        .code-container {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background: rgba(74, 74, 138, 0.1);
            border-radius: 12px;
        }
        
        .reset-code {
            font-size: 32px;
            font-weight: 700;
            color: #4A4A8A;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
            margin: 10px 0;
        }
        
        .security-note {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #4A4A8A;
        }
        
        .footer {
            text-align: center;
            color: #888;
            font-size: 14px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">Password Reset</div>
            <h1 class="title">Reset Your Password</h1>
        </div>
        
        <div class="content">
            <p>Hello {{ $user->name }},</p>
            
            <p>You requested to reset your password. Use the following code to complete the reset process:</p>
            
            <div class="code-container">
                <p style="margin: 0 0 10px 0; font-weight: 600;">Your reset code is:</p>
                <div class="reset-code">{{ $code }}</div>
                <p style="margin: 10px 0 0 0; font-size: 14px; color: #666;">This code will expire in 15 minutes</p>
            </div>
            
            <div class="security-note">
                <strong>Security Note:</strong> This code is valid for 15 minutes only. If you didn't request this password reset, please ignore this email and your password will remain unchanged.
            </div>
            
            <p>If you're having trouble with the code above, you can also copy and paste it directly into the reset form.</p>
        </div>
        
        <div class="footer">
            <p>This email was sent to {{ $user->email }}. If you didn't request this, please ignore this email.</p>
            <p>&copy; {{ date('Y') }} Your App Name. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
