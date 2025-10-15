<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
            max-width: 420px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
            margin: 20px;
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

        .form-input:focus {
            border-color: #EC4899;
            background: #333333;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.2);
        }

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
            text-decoration: none;
            font-size: 14px;
        }

        .resend-section a:hover {
            text-decoration: underline;
        }

        .resend-section a.disabled {
            color: #666666;
            cursor: not-allowed;
        }

        .error-message {
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
            display: none;
        }

        .form-input.error {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2);
        }

        .form-input.success {
            border-color: #EC4899;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.2);
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
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 12S5 4 12 4s11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2" fill="none"/>
                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" fill="none"/>
                        </svg>
                    </button>
                </div>
                <div class="error-message" id="passwordError">Password must be at least 8 characters long</div>
            </div>

            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <div class="password-input-container">
                    <input type="password" name="password_confirmation" id="passwordConfirmation" class="form-input" placeholder="Confirm your password" required>
                    <button type="button" class="password-toggle" id="confirmPasswordToggle">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 12S5 4 12 4s11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2" fill="none"/>
                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" fill="none"/>
                        </svg>
                    </button>
                </div>
                <div class="error-message" id="passwordConfirmationError">Passwords do not match</div>
            </div>

            <button type="submit" class="continue-btn" id="passwordBtn">
                <span class="loading" id="loading"></span>
                <span id="btnText">Create Account</span>
            </button>
        </form>

        <div class="resend-section">
            <a href="#" id="resendLink">Didn't receive a code? Resend <span id="countdown">(30)</span></a>
        </div>

        <div class="divider">
            <span>OR</span>
        </div>

        <div class="back-link">
            <a href="{{ route('register') }}">Go back to registration</a>
        </div>

        <div class="developer-credit">
            <p>Developed by: Roiz Abajon & ALFONSO</p>
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
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        });

        document.getElementById('confirmPasswordToggle').addEventListener('click', function() {
            const passwordInput = document.querySelector('input[name="password_confirmation"]');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        });

        // Password validation
        const passwordInput = document.getElementById('password');
        const passwordConfirmationInput = document.getElementById('passwordConfirmation');
        const passwordError = document.getElementById('passwordError');
        const passwordConfirmationError = document.getElementById('passwordConfirmationError');

        function validatePassword() {
            const password = passwordInput.value;
            const isValid = password.length >= 8;
            
            if (password.length > 0) {
                if (isValid) {
                    passwordInput.classList.remove('error');
                    passwordInput.classList.add('success');
                    passwordError.style.display = 'none';
                } else {
                    passwordInput.classList.remove('success');
                    passwordInput.classList.add('error');
                    passwordError.style.display = 'block';
                }
            } else {
                passwordInput.classList.remove('error', 'success');
                passwordError.style.display = 'none';
            }
            
            return isValid;
        }

        function validatePasswordConfirmation() {
            const password = passwordInput.value;
            const confirmation = passwordConfirmationInput.value;
            const isValid = confirmation === password && confirmation.length > 0;
            
            if (confirmation.length > 0) {
                if (isValid) {
                    passwordConfirmationInput.classList.remove('error');
                    passwordConfirmationInput.classList.add('success');
                    passwordConfirmationError.style.display = 'none';
                } else {
                    passwordConfirmationInput.classList.remove('success');
                    passwordConfirmationInput.classList.add('error');
                    passwordConfirmationError.style.display = 'block';
                }
            } else {
                passwordConfirmationInput.classList.remove('error', 'success');
                passwordConfirmationError.style.display = 'none';
            }
            
            return isValid;
        }

        passwordInput.addEventListener('input', function() {
            validatePassword();
            validatePasswordConfirmation(); // Re-validate confirmation when password changes
        });

        passwordConfirmationInput.addEventListener('input', validatePasswordConfirmation);

        // Form submission with validation
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            const passwordValid = validatePassword();
            const confirmationValid = validatePasswordConfirmation();
            
            if (!passwordValid || !confirmationValid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please fix the password validation errors before submitting.',
                    confirmButtonColor: '#9333EA'
                });
                return;
            }
            
            const btn = document.getElementById('passwordBtn');
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
                confirmButtonColor: '#9333EA'
            });
        @endif

        // Display success messages
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#9333EA'
            });
        @endif

        // Display info messages
        @if (session('info'))
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: '{{ session('info') }}',
                confirmButtonColor: '#9333EA'
            });
        @endif

        // Display error messages
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonColor: '#9333EA'
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
                        text: 'A new verification code has been sent to your email.',
                        confirmButtonColor: '#9333EA'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to send verification code.',
                        confirmButtonColor: '#9333EA'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.',
                    confirmButtonColor: '#9333EA'
                });
            });
        }

        // Start countdown on page load
        updateCountdown();
    </script>
</body>
</html>
