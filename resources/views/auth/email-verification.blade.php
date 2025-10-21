<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
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
            text-align: center;
        }

        .logo {
            margin-bottom: 24px;
            display: flex;
            justify-content: center;
        }

        .auth-title {
            font-size: 24px;
            font-weight: 600;
            color: #FFFFFF;
            margin-bottom: 16px;
            text-align: center;
        }

        .auth-message {
            font-size: 14px;
            color: #9CA3AF;
            text-align: center;
            margin-bottom: 32px;
        }

        .email-address {
            font-weight: 600;
            color: #FFFFFF;
            margin-top: 4px;
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

        /* Remove hover color on inputs */

        .code-input:active {
            border-color: #9BD3DD;
            box-shadow: 0 0 0 3px rgba(155, 211, 221, 0.3);
        }

        .code-input.filled {
            border-color: #9BD3DD;
            background: #333333;
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

        /* spinner/button styles removed */

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
            background: #FFFFFF;
            color: #000000;
        }

        .btn-primary:hover {
            background: #F3F4F6;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .auth-container {
                margin: 16px;
                padding: 40px 28px;
                max-width: 500px;
            }
            .auth-title { font-size: 28px; }
            .code-input { width: 44px; height: 44px; font-size: 17px; }
        }

        @media (max-width: 480px) {
            .auth-container {
                margin: 10px;
                padding: 32px 24px;
            }
            
            .auth-title {
                font-size: 28px;
            }
        }

        @media (max-width: 360px) {
            .code-inputs { gap: 8px; }
            .code-input { width: 38px; height: 38px; font-size: 16px; }
        }
    </style>
</head>
<body>

    <!-- Verification Container -->
    <div class="auth-container">
        
        <h1 class="auth-title">Verify your email</h1>
        
        @php($userEmail = Auth::user()->email ?? session('user_email') ?? 'your email address')
        @php($maskedEmail = $userEmail !== 'your email address' ? preg_replace('/(^.).+(@.*$)/', '$1***$2', $userEmail) : $userEmail)
        
        <div class="auth-message">
            <p>Code sent to <span class="email-address">{{ $maskedEmail }}</span></p>
        </div>

        <form id="verificationForm" method="POST" action="{{ route('email.verify') }}">
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
            <p style="color:#9CA3AF; font-size:14px;">
                Didn't receive a code?
                <a href="#" id="resendLink">Resend</a> <span id="countdown" style="color:#9CA3AF">(30)</span>
            </p>
        </div>

        <div class="back-link">
            <a href="{{ route('register') }}">Go back</a>
        </div>
    </div>

    <script>
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
                    confirmButtonColor: '#87CEEB',
                    confirmButtonText: 'OK'
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
                    confirmButtonColor: '#87CEEB',
                    confirmButtonText: 'OK'
                });
                return;
            }

            countdown = 30;
            updateCountdown();

            const formData = new FormData();
            formData.append('email', '{{ $userEmail }}');
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
                        title: 'Code Sent',
                        text: 'Your code has been sent to your email.',
                        confirmButtonColor: '#87CEEB',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to resend code.',
                        confirmButtonColor: '#87CEEB',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.',
                    confirmButtonColor: '#87CEEB',
                    confirmButtonText: 'OK'
                });
            });
        }

        if (resendLink) {
            resendLink.addEventListener('click', handleResend);
            updateCountdown();
        }

        // Display validation errors
        @if ($errors->any())
            console.log('Validation errors detected:', '{{ $errors->first() }}');
            Swal.fire({
                icon: 'error',
                title: 'Invalid Code',
                text: '{{ $errors->first() }}',
                confirmButtonColor: '#87CEEB',
                confirmButtonText: 'OK'
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

        // Display session error messages
        @if (session('error'))
            console.log('Session error detected:', '{{ session('error') }}');
            Swal.fire({
                icon: 'error',
                title: 'Invalid Code',
                text: '{{ session('error') }}',
                confirmButtonColor: '#87CEEB',
                confirmButtonText: 'OK'
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

        // Display session success messages
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#87CEEB',
                confirmButtonText: 'OK'
            });
        @endif

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
