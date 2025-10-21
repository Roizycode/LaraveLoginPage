<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign up</title>
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

        /* Prevent layout shifts and improve performance */
        html {
            scroll-behavior: smooth;
        }

        body, html {
            overflow-x: hidden;
        }

        /* Prevent container shaking */
        .auth-container * {
            transform-origin: center;
        }

        /* Smooth button interactions without affecting container */
        .continue-btn, .social-btn {
            transform-origin: center;
            transition: background-color 0.2s ease, transform 0.15s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #000000;
            background-image: url('https://i.pinimg.com/originals/19/6a/d9/196ad9d3122098b297d7b99ce9ff209f.gif');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: auto;
            position: relative;
            will-change: auto;
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

        /* Custom Scrollbar - Always visible */
        ::-webkit-scrollbar {
            width: 12px;
            height: 12px;
        }

        ::-webkit-scrollbar-track {
            background: #1a1a1a;
            border-radius: 6px;
            border: 1px solid #333;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #404040, #555555);
            border-radius: 6px;
            border: 1px solid #666;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.1);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #555555, #666666);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.2);
        }

        ::-webkit-scrollbar-thumb:active {
            background: linear-gradient(45deg, #666666, #777777);
        }

        ::-webkit-scrollbar-corner {
            background: #1a1a1a;
        }

        /* Force scrollbar to always show and enable scrolling */
        html {
            overflow-y: auto;
            overflow-x: hidden;
            height: 100%;
        }

        /* Main Container - moved to bottom to avoid conflicts */

        .auth-title {
            font-size: 32px;
            font-weight: 700;
            color: #FFFFFF;
            text-align: center;
            margin-bottom: 40px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-row {
            display: flex;
            gap: 12px;
        }

        .form-row .form-group {
            flex: 1;
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
            /* Prevent zoom on mobile when focusing input */
            font-size: 16px !important;
            transform: translateZ(0);
            -webkit-appearance: none;
            -webkit-tap-highlight-color: transparent;
        }

        .form-input:focus-visible {
            border-color: #9BD3DD;
            background: #333333;
            box-shadow: 0 0 0 3px rgba(155, 211, 221, 0.2);
        }

        /* No hover/active color changes; highlight only when focused */

        .form-input::placeholder {
            color: #9CA3AF;
        }

        .password-input-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9CA3AF;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .password-toggle:hover {
            color: #FFFFFF;
        }

        .password-toggle svg {
            width: 20px;
            height: 20px;
            transition: all 0.3s ease;
        }

        .password-toggle .eye-open {
            display: block;
        }

        .password-toggle .eye-closed {
            display: none;
        }

        .password-toggle.show-password .eye-open {
            display: none;
        }

        .password-toggle.show-password .eye-closed {
            display: block;
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
            transition: none; /* hover/active animations disabled */
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: translateZ(0);
            backface-visibility: hidden;
            will-change: background-color;
        }
        /* Removed hover/active animations for continue button */

        .divider {
            position: relative;
            text-align: center;
            margin: 24px 0;
            display: flex;
            align-items: center;
        }

        .divider::before {
            content: '';
            flex: 1;
            height: 1px;
            background: #404040;
        }

        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #404040;
        }

        .divider span {
            background: #1f1f1f;
            color: #FFFFFF;
            padding: 0 16px;
            font-size: 14px;
            white-space: nowrap;
        }

        .social-btn {
            width: 100%;
            padding: 12px 16px;
            background: #2a2a2a;
            color: #FFFFFF;
            border: 1px solid #404040;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.1s ease;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transform: translateZ(0);
            backface-visibility: hidden;
            will-change: background-color;
        }

        .social-btn:hover {
            background: #333333;
            transform: translateZ(0) scale(1.01);
        }

        .social-btn:active {
            transform: translateZ(0) scale(0.99);
        }

        .social-icon {
            width: 20px;
            height: 20px;
        }

        .auth-link {
            text-align: center;
            margin-top: 24px;
            color: #9CA3AF;
            font-size: 14px;
        }

        .auth-link a {
            color: #FFFFFF;
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
        @media (max-width: 480px) {
            .auth-container {
                padding: 32px 24px;
                max-width: calc(100vw - 20px);
                width: calc(100vw - 20px);
            }
            
            .auth-title {
                font-size: 28px;
                margin-bottom: 40px;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }
        }

        /* Ensure container never moves */
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
            backface-visibility: hidden;
            will-change: auto;
            contain: layout style paint;
            margin: 0 auto;
        }

        /* Prevent background zoom/shift on input focus */
        @media screen and (max-width: 768px) {
            .form-input {
                font-size: 16px !important;
                transform: translateZ(0);
            }
            
            body {
                background-attachment: scroll;
            }
            
            /* Prevent viewport zoom */
            input, textarea, select {
                font-size: 16px !important;
            }
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
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

    <!-- Sign up Form -->
    <div class="auth-container">
        <h1 class="auth-title">Sign up</h1>
        
        <form id="registerForm" method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">First name</label>
                    <input type="text" name="first_name" class="form-input" placeholder="Your first name" value="{{ old('first_name') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Last name</label>
                    <input type="text" name="last_name" class="form-input" placeholder="Your last name" value="{{ old('last_name') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" placeholder="Your email address" value="{{ old('email') }}" required>
            </div>


            <button type="submit" class="continue-btn" id="registerBtn">
                <span class="loading" id="loading"></span>
                <span id="btnText">Continue</span>
            </button>
        </form>

        <div class="divider">
            <span>OR</span>
        </div>

        <button class="social-btn" type="button" onclick="handleGoogleLogin()">
            <svg class="social-icon" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            Continue with Google
        </button>

        <button class="social-btn" type="button" onclick="handleGitHubLogin()">
            <svg class="social-icon" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
            </svg>
            Continue with GitHub
        </button>


        <div class="auth-link">
            Already have an account? <a href="{{ route('login') }}">Sign in</a>
        </div>

        <div class="terms">
            By signing up, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
        </div>

    </div>

    <!-- Extra content to enable scrolling -->
    <div style="height: 200px; width: 100%; position: absolute; top: 100vh; left: 0; z-index: -1;"></div>

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


        // Social login handlers (design only)
        function handleGoogleLogin() {
            Swal.fire({
                icon: 'info',
                title: 'Google Login',
                text: 'This is a design-only feature. Google login functionality would be implemented here.',
                confirmButtonColor: '#87CEEB'
            });
        }

        function handleGitHubLogin() {
            Swal.fire({
                icon: 'info',
                title: 'GitHub Login',
                text: 'This is a design-only feature. GitHub login functionality would be implemented here.',
                confirmButtonColor: '#87CEEB'
            });
        }

        // Form submission with loading state
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            // Combine first name and last name into name field
            const firstName = document.querySelector('input[name="first_name"]').value;
            const lastName = document.querySelector('input[name="last_name"]').value;
            const fullName = firstName.trim() + ' ' + lastName.trim();
            
            // Create a hidden input for the name field
            let nameInput = document.querySelector('input[name="name"]');
            if (!nameInput) {
                nameInput = document.createElement('input');
                nameInput.type = 'hidden';
                nameInput.name = 'name';
                this.appendChild(nameInput);
            }
            nameInput.value = fullName;

            const btn = document.getElementById('registerBtn');
            const loading = document.getElementById('loading');
            const btnText = document.getElementById('btnText');
            
            // Hide text and show loading spinner in center
            btnText.style.display = 'none';
            loading.style.display = 'inline-block';
            btn.disabled = true;
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
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#87CEEB',
                confirmButtonText: 'OK'
            });
        @endif

        // Display info messages
        @if (session('info'))
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: '{{ session('info') }}',
                confirmButtonColor: '#87CEEB',
                confirmButtonText: 'OK'
            });
        @endif

        // Display error messages
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonColor: '#87CEEB',
                confirmButtonText: 'OK'
            });
        @endif

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

        // Refresh CSRF token before form submission
        document.getElementById('registerForm').addEventListener('submit', function(e) {
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
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
