<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enter Verification Code</title>
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
            font-size: 24px;
            font-weight: 600;
            color: #FFFFFF;
            text-align: center;
            margin-bottom: 16px;
        }

        .auth-message {
            font-size: 14px;
            color: #FFFFFF;
            text-align: center;
            margin-bottom: 32px;
        }

        .email-address {
            font-weight: 600;
            color: #FFFFFF;
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

        .code-inputs {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-bottom: 24px;
        }

        .code-input {
            width: 48px;
            height: 48px;
            border: 2px solid #404040;
            border-radius: 8px;
            background: #2a2a2a;
            color: #FFFFFF;
            font-size: 18px;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s ease;
            outline: none;
        }

        .code-input:focus-visible {
            border-color: #9BD3DD;
            background: #333333;
            box-shadow: 0 0 0 3px rgba(155, 211, 221, 0.25);
        }

        .code-input.filled {
            border-color: #9BD3DD;
            background: #333333;
        }

        .resend-section {
            text-align: center;
            margin-bottom: 24px;
        }

        .resend-section p {
            color: #9CA3AF;
            font-size: 14px;
            margin: 0;
        }

        .resend-section a {
            color: #ffffff;
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

        .back-link {
            text-align: center;
        }

        .back-link a {
            color: #9CA3AF;
            text-decoration: none;
            font-size: 14px;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .auth-container {
                margin: 16px;
                padding: 40px 28px;
                max-width: 500px;
            }
            .auth-title { font-size: 28px; }
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

            .code-inputs {
                gap: 8px;
            }

            .code-input {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }
        }

        @media (max-width: 360px) {
            .code-input { width: 36px; height: 36px; font-size: 15px; }
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
    @php($loginEmail = session('login_email'))
    @if(!$loginEmail)
        <script>window.location.href = '{{ route('login') }}';</script>
    @endif
    @php($masked = $loginEmail ? preg_replace('/(^.).+(@.*$)/', '$1***$2', $loginEmail) : '')
    @php($display = $masked)

    <!-- Verification Code Form -->
    <div class="auth-container">
        <h1 class="auth-title">Verify your email</h1>
        
        <div class="auth-message">
            <p style="color:#9CA3AF; font-size:14px;">Code sent to <span class="email-address">{{ $display }}</span></p>
        </div>

        <form method="POST" action="{{ route('login.verify.code.submit') }}" id="verificationForm">
            @csrf
            <div class="code-inputs">
                <input type="text" name="code1" class="code-input" maxlength="1" pattern="[0-9]" required>
                <input type="text" name="code2" class="code-input" maxlength="1" pattern="[0-9]" required>
                <input type="text" name="code3" class="code-input" maxlength="1" pattern="[0-9]" required>
                <input type="text" name="code4" class="code-input" maxlength="1" pattern="[0-9]" required>
                <input type="text" name="code5" class="code-input" maxlength="1" pattern="[0-9]" required>
                <input type="text" name="code6" class="code-input" maxlength="1" pattern="[0-9]" required>
            </div>
            <input type="hidden" name="code" id="verificationCode">
        </form>

        <div class="resend-section">
            <p>
                Didn't receive a code?
                <a href="#" id="resendLink">Resend</a><span id="countdown">(30)</span>
            </p>
        </div>

        <div class="back-link">
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

        // Code input functionality
        const codeInputs = document.querySelectorAll('.code-input');
        const verificationCode = document.getElementById('verificationCode');
        
        const resendLink = document.getElementById('resendLink');
        const countdownSpan = document.getElementById('countdown');
        let countdown = 30;

        codeInputs.forEach((input, index) => {
            input.addEventListener('input', function(e) {
                // Only allow numbers
                this.value = this.value.replace(/[^0-9]/g, '');
                
                // Add filled class
                if (this.value) {
                    this.classList.add('filled');
                } else {
                    this.classList.remove('filled');
                }
                
                // Move to next input if current is filled
                if (this.value.length === 1 && index < codeInputs.length - 1) {
                    codeInputs[index + 1].focus();
                }
                
                // Update hidden input with full code
                updateVerificationCode();
                
                // Auto-submit when 6th digit is entered
                if (index === 5 && this.value.length === 1) {
                    const fullCode = verificationCode.value;
                    if (fullCode.length === 6) {
                        // Disable inputs and show button spinner
                        codeInputs.forEach(input => {
                            input.disabled = true;
                            input.style.opacity = '0.6';
                        });
                        document.getElementById('verificationForm').submit();
                    }
                }
            });

            input.addEventListener('keydown', function(e) {
                // Move to previous input on backspace if current is empty
                if (e.key === 'Backspace' && this.value === '' && index > 0) {
                    codeInputs[index - 1].focus();
                    codeInputs[index - 1].classList.remove('filled');
                }
            });

            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text');
                const numbers = pastedData.replace(/\D/g, '').slice(0, 6);
                
                numbers.split('').forEach((num, i) => {
                    if (codeInputs[i]) {
                        codeInputs[i].value = num;
                        codeInputs[i].classList.add('filled');
                    }
                });
                
                updateVerificationCode();
                
                // Auto-submit when 6 digits are pasted
                if (numbers.length >= 6) {
                    const fullCode = verificationCode.value;
                    if (fullCode.length === 6) {
                        codeInputs.forEach(input => {
                            input.disabled = true;
                            input.style.opacity = '0.6';
                        });
                        document.getElementById('verificationForm').submit();
                    }
                }
            });
        });

        function updateVerificationCode() {
            const code = Array.from(codeInputs).map(input => input.value).join('');
            verificationCode.value = code;
        }

        // Form validation
        document.getElementById('verificationForm').addEventListener('submit', function(e) {
            const code = verificationCode.value;
            
            if (code.length !== 6) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Code',
                    text: 'Please enter a complete 6-digit code.',
                    confirmButtonColor: '#87CEEB'
                });
                return;
            }
        });

        // Resend logic with countdown
        function updateCountdown() {
            if (!countdownSpan) return;
            countdownSpan.textContent = `(${countdown})`;
            if (countdown > 0) {
                countdown--;
                setTimeout(updateCountdown, 1000);
            }
        }

        function handleResend(e) {
            e.preventDefault();
            if (countdown > 0) {
                Swal.fire({
                    icon: 'info',
                    title: 'Please wait',
                    text: `A new code will be sent in ${countdown} seconds`,
                    confirmButtonColor: '#87CEEB'
                });
                return;
            }

            countdown = 30;
            updateCountdown();

            const formData = new FormData();
            formData.append('email', '{{ $loginEmail }}');
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            fetch('{{ route("login.send.code") }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Code Sent',
                        text: 'Your code has been sent to your email.',
                        confirmButtonColor: '#87CEEB'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to resend code.',
                        confirmButtonColor: '#87CEEB'
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.',
                    confirmButtonColor: '#87CEEB'
                });
            });
        }

        if (resendLink) {
            resendLink.addEventListener('click', handleResend);
            updateCountdown();
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

        // Display validation errors
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Invalid Code',
                text: '{{ $errors->first() }}',
                confirmButtonColor: '#87CEEB'
            }).then(() => {
                // Re-enable inputs and clear them
                codeInputs.forEach(input => {
                    input.disabled = false;
                    input.style.opacity = '1';
                    input.value = '';
                    input.classList.remove('filled');
                });
                verificationCode.value = '';
                codeInputs[0].focus();
            });
        @endif


        // Display error messages
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Invalid Code',
                text: '{{ session('error') }}',
                confirmButtonColor: '#87CEEB'
            }).then(() => {
                // Re-enable inputs and clear them
                codeInputs.forEach(input => {
                    input.disabled = false;
                    input.style.opacity = '1';
                    input.value = '';
                    input.classList.remove('filled');
                });
                verificationCode.value = '';
                codeInputs[0].focus();
            });
        @endif
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
