<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="/people.png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #000000;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
        }

        .dashboard-container {
            background: #1f1f1f;
            border: 1px solid #333333;
            border-radius: 16px;
            padding: 48px;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
            max-width: 500px;
            width: 100%;
            margin: 20px;
        }

        .welcome-title {
            font-size: 32px;
            font-weight: 700;
            color: #FFFFFF;
            margin-bottom: 16px;
        }

        .welcome-message {
            font-size: 16px;
            color: #9CA3AF;
            margin-bottom: 32px;
        }

        .user-info {
            background: #2a2a2a;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 32px;
        }

        .user-name {
            font-size: 18px;
            font-weight: 600;
            color: #FFFFFF;
            margin-bottom: 8px;
        }

        .user-email {
            font-size: 14px;
            color: #9CA3AF;
        }

        .logout-btn {
            background: #9333EA;
            color: #FFFFFF;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.1s ease;
            text-decoration: none;
            display: inline-block;
            transform: translateZ(0);
            backface-visibility: hidden;
            will-change: background-color;
        }

        .logout-btn:hover {
            background: #7C3AED;
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
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1 class="welcome-title">Welcome!</h1>
        <p class="welcome-message">Your account has been successfully created and verified.</p>
        
        <div class="user-info">
            <div class="user-name">{{ Auth::user()->name }}</div>
            <div class="user-email">{{ Auth::user()->email }}</div>
        </div>

        <a href="{{ route('logout') }}" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <div class="developer-credit">
            <p>Developed by: Roiz Abajon & ALFONSO</p>
        </div>
    </div>

    <script>
        // Display success message if present
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Welcome Back!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#9333EA',
                confirmButtonText: 'Continue',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: true
            });
        @endif

        // Display info message if present (for already verified users)
        @if (session('info'))
            Swal.fire({
                icon: 'info',
                title: 'ℹ️ Info',
                text: '{{ session('info') }}',
                confirmButtonColor: '#9333EA'
            });
        @endif
    </script>
</body>
</html>
