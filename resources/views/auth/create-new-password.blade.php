<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create New Password</title>
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
            overflow-x: auto;
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
        }

        .form-input:focus-visible {
            border-color: #9BD3DD;
            background: #333333;
            box-shadow: 0 0 0 3px rgba(155, 211, 221, 0.25);
        }


        .form-input:active {
            border-color: #9BD3DD;
            box-shadow: 0 0 0 3px rgba(155, 211, 221, 0.3);
        }

        .form-input::placeholder {
            color: #9CA3AF;
        }

        .form-input.password-weak {
            border-color: #EF4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2);
        }

        .form-input.password-common {
            border-color: #F59E0B;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.2);
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
        /* Remove input hover effect so styling applies only on focus/active */


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

            /* Ensure input controls are easy to tap on small screens */
            .form-input {
                font-size: 16px; /* prevent iOS zoom */
                padding: 14px 16px;
            }

            .continue-btn {
                padding: 14px;
                font-size: 16px;
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

    <!-- Create New Password Form -->
    <div class="auth-container">
        <h1 class="auth-title">Create New Password</h1>
        
        <form id="passwordForm" method="POST" action="{{ route('password.reset') }}">
            @csrf
            <input type="hidden" name="code" value="{{ session('reset_code') }}">
            
            <div class="form-group">
                <label class="form-label">New Password</label>
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
                    <button type="button" class="password-toggle" id="confirmPasswordToggle">
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
                <span id="btnText">Reset Password</span>
            </button>
        </form>

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
            const passwordInput = document.getElementById('password');
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

        document.getElementById('confirmPasswordToggle').addEventListener('click', function() {
            const passwordInput = document.getElementById('password_confirmation');
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
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Password Mismatch',
                    text: 'Passwords do not match. Please try again.',
                    confirmButtonColor: '#87CEEB',
                    confirmButtonText: 'OK'
                });
                return;
            }
            
            if (password.length < 8) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Password Too Short',
                    text: 'Password must be at least 8 characters long.',
                    confirmButtonColor: '#87CEEB',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Check if password is too common or weak
            const commonPasswords = ['password', '123456', '123456789', 'qwerty', 'abc123', 'password123', 'admin', 'letmein', 'welcome', 'monkey'];
            if (commonPasswords.includes(password.toLowerCase())) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Password Too Common',
                    text: 'Please choose a more secure password. This password is too commonly used.',
                    confirmButtonColor: '#87CEEB',
                    confirmButtonText: 'OK'
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
                confirmButtonColor: '#87CEEB',
                confirmButtonText: 'OK'
            }).then(() => {
                // Re-enable button and restore text
                const btn = document.getElementById('passwordBtn');
                const loading = document.getElementById('loading');
                const btnText = document.getElementById('btnText');
                
                btnText.style.display = 'inline';
                loading.style.display = 'none';
                btn.disabled = false;
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

        // Display error messages
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonColor: '#87CEEB',
                confirmButtonText: 'OK'
            }).then(() => {
                // Re-enable button and restore text
                const btn = document.getElementById('passwordBtn');
                const loading = document.getElementById('loading');
                const btnText = document.getElementById('btnText');
                
                btnText.style.display = 'inline';
                loading.style.display = 'none';
                btn.disabled = false;
            });
        @endif
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
