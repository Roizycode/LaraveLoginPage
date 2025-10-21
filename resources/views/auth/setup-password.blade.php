<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Password</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: auto;
            position: relative;
            /* Prevent zoom on input focus */
            touch-action: manipulation;
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
            backface-visibility: hidden;
            will-change: auto;
            contain: layout style paint;
            margin: 0 auto;
        }

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

        /* Remove hover color changes for inputs */

        .form-input:active {
            border-color: #9BD3DD;
            box-shadow: 0 0 0 3px rgba(155, 211, 221, 0.3);
        }

        .form-input::placeholder {
            color: #9CA3AF;
        }



        .password-input-container {
            position: relative;
        }

        .helper-text {
            margin-top: 8px;
            color: #9CA3AF;
            font-size: 12px;
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
            transition: all 0.3s ease;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .continue-btn:hover {
            background: #F3F4F6;
        }

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

        .back-link {
            text-align: center;
            margin-top: 24px;
            color: #9CA3AF;
            font-size: 14px;
        }

        .back-link a {
            color: #9CA3AF;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link a:hover {
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

        .resend-section {
            text-align: center;
            margin-bottom: 24px;
        }

        .resend-section a {
            color: #FFFFFF;
            text-decoration: underline;
            font-size: 14px;
        }

        .resend-section a:hover {
            text-decoration: underline;
        }

        .resend-section a.disabled {
            color: #666666;
            cursor: not-allowed;
        }

        /* Removed red error styling during typing */

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

        /* Responsive Design */
        @media (max-width: 480px) {
            .auth-container {
                margin: 10px;
                padding: 32px 24px;
            }
            
            .auth-title {
                font-size: 28px;
                margin-bottom: 32px;
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

    <!-- Password Setup Form -->
    <div class="auth-container">
        <h1 class="auth-title">Create Password</h1>
        
        <form id="passwordForm" method="POST" action="{{ route('register.password') }}">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="password-input-container">
                    <input type="password" name="password" id="password" class="form-input" placeholder="Create a strong password" required>
                    <button type="button" class="password-toggle" id="passwordToggle">
                        <!-- Open Eye Icon (visible when password is hidden) -->
                        <svg class="eye-open" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 12S5 4 12 4s11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2" fill="none"/>
                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" fill="none"/>
                        </svg>
                        <!-- Closed Eye Icon (visible when password is shown) -->
                        <svg class="eye-closed" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" stroke="currentColor" stroke-width="2" fill="none"/>
                            <line x1="1" y1="1" x2="23" y2="23" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <div class="password-input-container">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="Confirm your password" required>
                    <button type="button" class="password-toggle" id="passwordConfirmationToggle">
                        <!-- Open Eye Icon (visible when password is hidden) -->
                        <svg class="eye-open" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 12S5 4 12 4s11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2" fill="none"/>
                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" fill="none"/>
                        </svg>
                        <!-- Closed Eye Icon (visible when password is shown) -->
                        <svg class="eye-closed" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" stroke="currentColor" stroke-width="2" fill="none"/>
                            <line x1="1" y1="1" x2="23" y2="23" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="continue-btn" id="passwordBtn">
                <span class="loading" id="loading"></span>
                <span id="btnText">Continue</span>
            </button>
            
            <div class="divider"><span>OR</span></div>
            
            <button type="button" class="continue-btn" id="emailCodeBtn" onclick="sendEmailCode()">
                <span class="loading" id="emailLoading"></span>
                <span id="emailBtnText">
                    <!-- Email icon -->
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px">
                        <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                        <path d="m22 7-10 5L2 7"></path>
                    </svg>
                    Continue with email code
                </span>
            </button>
        </form>

        <div class="account-info" style="text-align: center; margin-top: 24px;">
            <p style="color: #9CA3AF; font-size: 14px; margin: 0; line-height: 1.5;">
                By creating an account, you agree to our terms of service and privacy policy. 
                We'll send you a verification code to confirm your email address.
            </p>
        </div>

        <div class="resend-section">
        </div>


        <div class="back-link">
            <a href="{{ route('register') }}">Go back</a>
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

        // Password toggle functionality
        document.getElementById('passwordToggle').addEventListener('click', function() {
            const passwordInput = document.querySelector('input[name="password"]');
            const toggleButton = this;
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle the eye icon classes
            if (type === 'text') {
                toggleButton.classList.add('show-password');
            } else {
                toggleButton.classList.remove('show-password');
            }
        });

        // Password confirmation toggle functionality
        document.getElementById('passwordConfirmationToggle').addEventListener('click', function() {
            const passwordInput = document.querySelector('input[name="password_confirmation"]');
            const toggleButton = this;
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle the eye icon classes
            if (type === 'text') {
                toggleButton.classList.add('show-password');
            } else {
                toggleButton.classList.remove('show-password');
            }
        });

        // Password validation
        const passwordInput = document.getElementById('password');
        const passwordConfirmationInput = document.getElementById('password_confirmation');

        function validatePassword() {
            const password = passwordInput.value;
            const passwordConfirmation = passwordConfirmationInput.value;
            const isValid = password.length >= 8 && password === passwordConfirmation;
            // No live styling changes while typing
            return isValid;
        }

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

        // Form submission with validation and CSRF token refresh
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            const passwordValid = validatePassword();
            if (!passwordValid) {
                e.preventDefault();
                const password = passwordInput.value;
                const passwordConfirmation = passwordConfirmationInput.value;
                
                let errorMessage = '';
                if (password.length < 8) {
                    errorMessage = 'Password must be at least 8 characters.';
                } else if (password !== passwordConfirmation) {
                    errorMessage = 'Passwords do not match.';
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: errorMessage,
                    confirmButtonColor: '#87CEEB'
                });
                return;
            }
            
            // Show loading spinner
            const btn = document.getElementById('passwordBtn');
            const loading = document.getElementById('loading');
            const btnText = document.getElementById('btnText');
            
            // Hide text and show loading spinner in center
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
                confirmButtonColor: '#87CEEB'
            });
        @endif

        // Display success messages
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#87CEEB'
            });
        @endif

        // Display info messages
        @if (session('info'))
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: '{{ session('info') }}',
                confirmButtonColor: '#87CEEB'
            });
        @endif

        // Display error messages
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonColor: '#87CEEB'
            });
        @endif

        // Resend functionality with countdown
        let countdown = 30;
        const resendLink = document.getElementById('resendLink');
        const countdownSpan = document.getElementById('countdown');

        function updateCountdown() {
            countdownSpan.textContent = `(${countdown})`;
            if (countdown > 0) {
                countdown--;
                setTimeout(updateCountdown, 1000);
            } else {
                resendLink.classList.remove('disabled');
                resendLink.onclick = handleResend;
            }
        }

        function handleResend(e) {
            e.preventDefault();
            
            if (resendLink.classList.contains('disabled')) return;

            resendLink.classList.add('disabled');
            countdown = 30;
            updateCountdown();

            // Send resend request
            const formData = new FormData();
            formData.append('email', '{{ Auth::user()->email ?? "" }}');
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            fetch('{{ route("email.resend") }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Code Sent!',
                        text: '✨ Code sent! Check your email for the verification code.',
                        confirmButtonColor: '#87CEEB'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to send verification code.',
                        confirmButtonColor: '#87CEEB'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.',
                    confirmButtonColor: '#87CEEB'
                });
            });
        }

        // Start countdown on page load
        updateCountdown();

        // Send email code functionality
        function sendEmailCode() {
            const emailCodeBtn = document.getElementById('emailCodeBtn');
            const emailLoading = document.getElementById('emailLoading');
            const emailBtnText = document.getElementById('emailBtnText');
            
            // Show loading spinner (same pattern as continue button)
            emailBtnText.style.display = 'none';
            emailLoading.style.display = 'inline-block';
            emailCodeBtn.disabled = true;

            // Get user email from session (for new registrations, Auth user might be null)
            const userEmail = '{{ session("user_email") ?? "" }}';
            
            // Debug: Log the email being used
            console.log('Using email for verification:', userEmail);
            console.log('Session email:', '{{ session("user_email") ?? "null" }}');
            console.log('Auth user email:', '{{ Auth::user()->email ?? "null" }}');
            
            // Show user what email is being used
            if (userEmail) {
                console.log('Sending verification code to:', userEmail);
            }
            
            if (!userEmail) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No email found. Please try registering again.',
                    confirmButtonColor: '#87CEEB'
                });
                // Restore button state
                emailBtnText.style.display = 'inline';
                emailLoading.style.display = 'none';
                emailCodeBtn.disabled = false;
                return;
            }

            // First refresh CSRF token
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
                }
                
                // Now send the email code request
                const formData = new FormData();
                formData.append('email', userEmail);
                formData.append('_token', data.csrf_token || document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                return fetch('{{ route("email.send.registration.code") }}', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData
                });
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Redirect to email verification page without showing modal
                    window.location.href = '{{ route("email.verification.required") }}';
                } else {
                    // Handle specific error cases
                    if (data.message && data.message.includes('Email already verified')) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Account Already Exists',
                            text: 'An account with this email already exists and is verified. Please log in instead of registering.',
                            confirmButtonColor: '#87CEEB'
                        }).then(() => {
                            // Redirect to login page
                            window.location.href = '{{ route("login") }}';
                        });
                    } else if (data.message && data.message.includes('Please complete the registration form first')) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Registration Required',
                            text: 'Please complete the registration form first. Go back and fill in your details.',
                            confirmButtonColor: '#87CEEB'
                        }).then(() => {
                            // Redirect to registration page
                            window.location.href = '{{ route("register") }}';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to send verification code.',
                            confirmButtonColor: '#87CEEB'
                        });
                        // Restore button state
                        emailBtnText.style.display = 'inline';
                        emailLoading.style.display = 'none';
                        emailCodeBtn.disabled = false;
                    }
                }
            })
            .catch(error => {
                console.error('Error sending email code:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.',
                    confirmButtonColor: '#87CEEB'
                });
                // Restore button state
                emailBtnText.style.display = 'inline';
                emailLoading.style.display = 'none';
                emailCodeBtn.disabled = false;
            });
        }
    </script>
</body>
</html>
