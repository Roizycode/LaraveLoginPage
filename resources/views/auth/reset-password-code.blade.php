<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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

        .form-input:focus {
            border-color: #EC4899;
            background: #333333;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.2);
        }

        .form-input::placeholder {
            color: #9CA3AF;
        }

        .code-inputs {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin: 24px 0;
        }

        .code-input {
            width: 48px;
            height: 48px;
            border: 1px solid #404040;
            border-radius: 8px;
            background: #2a2a2a;
            font-size: 20px;
            font-weight: 600;
            color: #FFFFFF;
            text-align: center;
            transition: all 0.3s ease;
            outline: none;
        }

        .code-input:focus {
            border-color: #EC4899;
            background: #333333;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.2);
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
        @media (max-width: 480px) {
            .auth-container {
                margin: 10px;
                padding: 32px 24px;
            }
            
            .auth-title {
                font-size: 28px;
                margin-bottom: 12px;
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
            margin-right: 8px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

    <!-- Reset Password Form -->
    <div class="auth-container">
        <h1 class="auth-title">Reset Password</h1>
        <p class="auth-subtitle">Enter the code sent to your email address</p>
        
        <form id="resetForm" method="POST" action="{{ route('password.verify.code') }}">
            @csrf
            
            <div class="code-inputs">
                <input type="text" name="code1" class="code-input" maxlength="1" pattern="[0-9]" required>
                <input type="text" name="code2" class="code-input" maxlength="1" pattern="[0-9]" required>
                <input type="text" name="code3" class="code-input" maxlength="1" pattern="[0-9]" required>
                <input type="text" name="code4" class="code-input" maxlength="1" pattern="[0-9]" required>
                <input type="text" name="code5" class="code-input" maxlength="1" pattern="[0-9]" required>
                <input type="text" name="code6" class="code-input" maxlength="1" pattern="[0-9]" required>
            </div>
            
            <input type="hidden" name="code" id="fullCode">

            <button type="submit" class="continue-btn" id="resetBtn">
                <span class="loading" id="loading"></span>
                <span id="btnText">Continue</span>
            </button>
        </form>

        <div class="auth-link">
            <a href="{{ route('login') }}">Back to Login</a>
        </div>

        <div class="terms">
            <a href="#">Terms of Service and Privacy Policy</a>
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

        // Code input functionality
        const codeInputs = document.querySelectorAll('.code-input');
        const fullCodeInput = document.getElementById('fullCode');

        codeInputs.forEach((input, index) => {
            input.addEventListener('input', function(e) {
                // Only allow numbers
                this.value = this.value.replace(/[^0-9]/g, '');
                
                // Move to next input if current is filled
                if (this.value.length === 1 && index < codeInputs.length - 1) {
                    codeInputs[index + 1].focus();
                }
                
                // Update hidden input with full code
                updateFullCode();
                
                // Auto-submit when 6th digit is entered
                if (index === 5 && this.value.length === 1) {
                    setTimeout(() => {
                        const fullCode = fullCodeInput.value;
                        if (fullCode.length === 6) {
                            document.getElementById('resetForm').submit();
                        }
                    }, 100);
                }
            });

            input.addEventListener('keydown', function(e) {
                // Move to previous input on backspace if current is empty
                if (e.key === 'Backspace' && this.value === '' && index > 0) {
                    codeInputs[index - 1].focus();
                }
            });

            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '');
                
                for (let i = 0; i < pastedData.length && i < codeInputs.length; i++) {
                    codeInputs[i].value = pastedData[i];
                }
                
                // Focus the next empty input or the last one
                const nextEmpty = Array.from(codeInputs).find(input => !input.value);
                if (nextEmpty) {
                    nextEmpty.focus();
                } else {
                    codeInputs[codeInputs.length - 1].focus();
                }
                
                updateFullCode();
            });
        });

        function updateFullCode() {
            const code = Array.from(codeInputs).map(input => input.value).join('');
            fullCodeInput.value = code;
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

        // Form validation with CSRF token refresh
        document.getElementById('resetForm').addEventListener('submit', function(e) {
            const code = fullCodeInput.value;
            
            if (code.length !== 6) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Code',
                    text: 'Please enter a complete 6-digit code.',
                    confirmButtonColor: '#9333EA'
                });
                return;
            }
            
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
                confirmButtonColor: '#9333EA'
            });
        @endif

        // Display success messages
        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif
    </script>
</body>
</html>
