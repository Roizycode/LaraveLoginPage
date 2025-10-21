<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password</title>
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
        .auth-container {
            position: relative;
            z-index: 10;
            background: #1f1f1f;
            border: 1px solid #333333;
            border-radius: 16px;
            padding: 48px 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
            margin: 0 auto;
        }

        .auth-title {
            font-size: 32px;
            font-weight: 700;
            color: #FFFFFF;
            text-align: center;
            margin-bottom: 16px;
        }

        .auth-subtitle {
            font-size: 16px;
            color: #9CA3AF;
            text-align: center;
            margin-bottom: 40px;
            white-space: nowrap; /* default desktop */
        }

        .form-group {
            margin-bottom: 32px;
        }

        .form-label {
            display: block;
            color: #FFFFFF;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #404040;
            border-radius: 8px;
            background: #2a2a2a;
            font-size: 16px;
            color: #FFFFFF;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus-visible {
            border-color: #9BD3DD;
            background: #333333;
            box-shadow: 0 0 0 3px rgba(155, 211, 221, 0.25);
        }

        /* No hover styling on inputs to avoid color change on mouseover */

        .form-input:active {
            border-color: #9BD3DD;
            box-shadow: 0 0 0 3px rgba(155, 211, 221, 0.3);
        }

        .form-input::placeholder {
            color: #9CA3AF;
        }

        .continue-btn {
            width: 100%;
            padding: 16px;
            background: #FFFFFF;
            color: #000000;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 24px;
        }

        .continue-btn:hover {
            background: #F3F4F6;
        }

        .auth-link {
            text-align: center;
            margin-top: 24px;
            color: #9CA3AF;
            font-size: 14px;
        }

        .auth-link a {
            color: #9CA3AF;
            text-decoration: none;
            font-weight: 600;
        }

        .auth-link a:hover {
            text-decoration: underline;
        }

        .terms {
            text-align: center;
            margin-top: 40px;
            color: #9CA3AF;
            font-size: 12px;
        }

        .terms a {
            color: #9CA3AF;
            text-decoration: none;
        }

        .terms a:hover {
            text-decoration: underline;
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
        @media (max-width: 768px) {
            .auth-container {
                margin: 16px;
                padding: 40px 28px;
                max-width: 500px;
            }
            .auth-title {
                font-size: 30px;
            }
            .auth-subtitle {
                font-size: 15px;
            }
        }

        @media (max-width: 480px) {
            .auth-container {
                margin: 10px;
                padding: 32px 24px;
            }
            
            .auth-title {
                font-size: 28px;
                margin-bottom: 12px;
            }
            .auth-subtitle {
                white-space: normal; /* allow wrapping on small phones */
            }
        }

        @media (max-width: 360px) {
            .auth-title { font-size: 24px; }
            .form-input { font-size: 15px; }
            .continue-btn { font-size: 15px; padding: 14px; }
        }

        /* Loading Animation */
        .loading {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(0, 0, 0, 0.3);
            border-top: 2px solid #000000;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

    <!-- Forgot Password Form -->
    <div class="auth-container">
        <h1 class="auth-title">Forgot Password?</h1>
        <p class="auth-subtitle">Enter your email and we will send you a reset link</p>
        
        <form id="forgotForm" method="POST" action="{{ route('password.email') }}">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" placeholder="Your email address" value="{{ old('email') }}" required autofocus>
            </div>

            <button type="submit" class="continue-btn" id="resetBtn">
                <span class="loading" id="loading"></span>
                <span id="btnText">Continue</span>
            </button>
        </form>

        <div class="auth-link">
            <a href="{{ route('login') }}">Go back</a>
        </div>
    </div>

    <script>
        // SweetAlert2 configuration
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // CSRF Token Refresh
        function refreshCsrfToken() {
            fetch('/csrf-token', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.csrf_token) {
                    document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.csrf_token);
                    const csrfInputs = document.querySelectorAll('input[name="_token"]');
                    csrfInputs.forEach(input => {
                        input.value = data.csrf_token;
                    });
                }
            })
            .catch(error => {
                console.log('CSRF token refresh failed:', error);
            });
        }

        // Refresh CSRF token every 5 minutes
        setInterval(refreshCsrfToken, 300000);

        // Form submission with loading state and CSRF token refresh
        document.getElementById('forgotForm').addEventListener('submit', function(e) {
            // Show loading spinner
            const btn = document.getElementById('resetBtn');
            const loading = document.getElementById('loading');
            const btnText = document.getElementById('btnText');
            
            // Hide text and show loading spinner
            btnText.style.display = 'none';
            loading.style.display = 'inline-block';
            btn.disabled = true;
            
            // Prevent default submission temporarily
            e.preventDefault();
            
            // Get fresh CSRF token before submission
            fetch('/csrf-token', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.csrf_token) {
                    // Update the CSRF token in the form
                    const csrfInput = document.querySelector('input[name="_token"]');
                    if (csrfInput) {
                        csrfInput.value = data.csrf_token;
                    }
                    // Update meta tag
                    document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.csrf_token);
                    
                    // Now submit the form with the fresh token
                    this.submit();
                } else {
                    // If no token received, submit anyway (fallback)
                    this.submit();
                }
            })
            .catch(error => {
                console.log('CSRF token refresh failed:', error);
                // If refresh fails, submit anyway (fallback)
                this.submit();
            });
        });

        // Display validation errors
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: '{{ $errors->first() }}',
                confirmButtonColor: '#87CEEB',
                confirmButtonText: 'OK'
            });
        @endif

        // Display success messages
        @if (session('success'))
            // Redirect directly to reset form without showing modal
            window.location.href = '{{ route('password.reset.form') }}';
        @endif
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


