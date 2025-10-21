<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Verification Code</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #000000;
            background-image: url('https://i.pinimg.com/originals/19/6a/d9/196ad9d3122098b297d7b99ce9ff209f.gif');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: auto;
            position: relative;
            padding: 20px;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .email-container {
            position: relative;
            z-index: 10;
            background: #1f1f1f;
            border: 1px solid #333333;
            border-radius: 16px;
            padding: 48px 40px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
            margin: 0 auto;
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

        .auth-title {
            font-size: 24px;
            font-weight: 700;
            color: #FFFFFF;
            text-align: center;
            margin-bottom: 12px;
        }

        .auth-message {
            font-size: 16px;
            color: #9CA3AF;
            text-align: center;
            margin-bottom: 40px;
        }

        .email-address {
            font-weight: 600;
            color: #FFFFFF;
            margin-top: 4px;
        }

        .code-container {
            background: #2a2a2a;
            border: 2px solid #404040;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            margin: 40px 0;
        }

        .verification-code {
            font-size: 32px;
            font-weight: 700;
            color: #FFFFFF;
            letter-spacing: 8px;
            margin: 0;
            font-family: 'Courier New', monospace;
            text-shadow: 0 0 8px rgba(255, 255, 255, 0.1);
        }

        .instructions {
            color: #9CA3AF;
            font-size: 16px;
            line-height: 1.6;
            margin: 20px 0;
        }

        .warning {
            background: #2a2a2a;
            border: 1px solid #404040;
            border-radius: 8px;
            padding: 20px;
            margin: 30px 0;
            color: #9CA3AF;
        }

        .warning strong {
            color: #FFFFFF;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #404040;
            color: #9CA3AF;
            font-size: 14px;
        }

        .developer-credit {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #404040;
        }

        .developer-credit p {
            color: #FFFFFF;
            font-size: 12px;
            margin: 0;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .email-container {
                margin: 10px;
                padding: 32px 24px;
            }
            
            .auth-title {
                font-size: 28px;
                margin-bottom: 12px;
            }

            .verification-code {
                font-size: 36px;
                letter-spacing: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">✓</div>
            <h1 class="auth-title">Login Verification Code</h1>
        </div>
        
        <div class="auth-message">
            <p>Code sent to <span class="email-address">{{ $user->email ?? 'your email address' }}</span></p>
        </div>

        <div class="code-container">
            <p class="verification-code">{{ $code }}</p>
        </div>
        
        <p class="instructions">
            Enter this code on the login page to access your account. This code will expire in 10 minutes for security reasons.
        </p>
        
        <div class="warning">
            <strong>Security Notice:</strong> If you didn't request this login code, please ignore this email and consider changing your password.
        </div>
        
        <p class="instructions">
            If you're having trouble with the code, you can also log in using your password or request a new code.
        </p>

        <div class="footer">
            <p>This email was sent from your account security system.</p>
            <p>Please do not reply to this email.</p>
        </div>

        <div class="developer-credit">
            <p>Developed by: Roiz Abajon & ALFONSO</p>
        </div>
    </div>
</body>
</html>
