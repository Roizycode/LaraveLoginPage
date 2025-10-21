<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - {{ Auth::user()->name }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            background-image: url('https://i.pinimg.com/originals/19/6a/d9/196ad9d3122098b297d7b99ce9ff209f.gif');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
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

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #1f1f1f;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: #404040;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #666666;
        }

        /* Main Container */
        .dashboard-container {
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

        .welcome-title {
            font-size: 32px;
            font-weight: 700;
            color: #FFFFFF;
            margin-bottom: 16px;
            text-align: center;
        }

        .welcome-subtitle {
            font-size: 18px;
            color: #9CA3AF;
            text-align: center;
            margin-bottom: 32px;
        }

        .user-info {
            background: #2a2a2a;
            border: 1px solid #404040;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 32px;
        }

        .user-name {
            font-size: 24px;
            font-weight: 600;
            color: #9BD3DD;
            margin-bottom: 8px;
        }

        .user-email {
            font-size: 16px;
            color: #9CA3AF;
        }

        .user-role {
            font-size: 14px;
            color: #666666;
            margin-top: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: #2a2a2a;
            border: 1px solid #404040;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
        }

        .stat-number {
            font-size: 24px;
            font-weight: 700;
            color: #9BD3DD;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 14px;
            color: #9CA3AF;
        }

        .action-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #9BD3DD;
            color: #000000;
        }

        .btn-primary:hover {
            background: #87CEEB;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #404040;
            color: #FFFFFF;
            border: 1px solid #666666;
        }

        .btn-secondary:hover {
            background: #555555;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #dc3545;
            color: #FFFFFF;
        }

        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        .developer-credit {
            text-align: center;
            margin-top: 32px;
            padding-top: 20px;
            border-top: 1px solid #404040;
        }

        .developer-credit p {
            color: #FFFFFF;
            font-size: 12px;
            margin: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-container {
                margin: 16px;
                padding: 40px 28px;
                max-width: 500px;
            }
            
            .welcome-title { 
                font-size: 28px; 
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                max-width: 200px;
            }
        }

        @media (max-width: 480px) {
            .dashboard-container {
                margin: 10px;
                padding: 32px 24px;
            }
            
            .welcome-title {
                font-size: 24px;
            }
            
            .dashboard-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <h1 class="welcome-title">Welcome to Your Dashboard!</h1>
        <p class="welcome-subtitle">You're successfully logged in</p>
        
        <div class="user-info">
            <div class="user-name">{{ Auth::user()->name }}</div>
            <div class="user-email">{{ Auth::user()->email }}</div>
            @if(Auth::user()->role)
                <div class="user-role">{{ Auth::user()->role }}</div>
            @endif
        </div>

        <div class="dashboard-stats">
            <div class="stat-card">
                <div class="stat-number">{{ Auth::user()->created_at->format('d') }}</div>
                <div class="stat-label">Joined Day</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ Auth::user()->created_at->format('M') }}</div>
                <div class="stat-label">Joined Month</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ Auth::user()->created_at->format('Y') }}</div>
                <div class="stat-label">Joined Year</div>
            </div>
        </div>

        <div class="action-buttons">
            <button class="btn btn-primary" onclick="showWelcomeMessage()">Get Started</button>
            <a href="#" class="btn btn-secondary" onclick="showProfileInfo()">Profile Info</a>
            <a href="{{ route('logout') }}" class="btn btn-danger" onclick="event.preventDefault(); showLogoutConfirmation();">Logout</a>
        </div>

        <div class="developer-credit">
            <p>Developed by Roiz Abajon & ALFONSO</p>
        </div>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        // Show welcome message on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Check for session messages first
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Welcome Back!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#9BD3DD',
                    confirmButtonText: 'Ok!',
                    showCloseButton: true
                });
            @endif

            @if (session('info'))
                Swal.fire({
                    icon: 'info',
                    title: 'Information',
                    text: '{{ session('info') }}',
                    confirmButtonColor: '#9BD3DD',
                    confirmButtonText: 'OK'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#9BD3DD',
                    confirmButtonText: 'OK'
                });
            @endif
        });

        function showWelcomeMessage() {
            Swal.fire({
                icon: 'success',
                title: 'Hello {{ Auth::user()->name }}!',
                text: 'Thank you for logging in! You are now ready to explore your dashboard.',
                confirmButtonColor: '#9BD3DD',
                confirmButtonText: 'Close',
                showCloseButton: true
            });
        }

        function showProfileInfo() {
            Swal.fire({
                icon: 'info',
                title: 'Profile Information',
                html: `
                    <div style="text-align: left;">
                        <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p><strong>Role:</strong> {{ Auth::user()->role ?? 'User' }}</p>
                        <p><strong>Member Since:</strong> {{ Auth::user()->created_at->format('F j, Y') }}</p>
                        <p><strong>Email Verified:</strong> {{ Auth::user()->email_verified_at ? 'Yes' : 'No' }}</p>
                    </div>
                `,
                confirmButtonColor: '#9BD3DD',
                confirmButtonText: 'Close',
                showCloseButton: true
            });
        }

        function showLogoutConfirmation() {
            Swal.fire({
                icon: 'question',
                title: 'Are you sure?',
                text: 'You are about to logout from your account.',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Logout',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit logout form immediately
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
