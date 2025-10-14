<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
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
            max-width: 500px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
            margin: 20px;
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

        .code-input:focus {
            border-color: #EC4899;
            background: #333333;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.2);
        }

        .code-input.filled {
            border-color: #EC4899;
            background: #333333;
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
        @media (max-width: 480px) {
            .auth-container {
                margin: 10px;
                padding: 32px 24px;
            }
            
            .auth-title {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>

    <!-- Verification Container -->
    <div class="auth-container">
        
        <h1 class="auth-title">Verify your email</h1>
        
        <div class="auth-message">
            <p>Enter the code sent to {{ Auth::user()->email ?? 'your email address' }}</p>
        </div>

        <form id="verificationForm" method="POST" action="{{ route('dashboard') }}">
            @csrf
            <div class="code-inputs">
                <input type="text" class="code-input" maxlength="1" data-index="0" required>
                <input type="text" class="code-input" maxlength="1" data-index="1" required>
                <input type="text" class="code-input" maxlength="1" data-index="2" required>
                <input type="text" class="code-input" maxlength="1" data-index="3" required>
                <input type="text" class="code-input" maxlength="1" data-index="4" required>
                <input type="text" class="code-input" maxlength="1" data-index="5" required>
            </div>
            <input type="hidden" name="code" id="verificationCode">
        </form>

        <div class="resend-section">
            <a href="#" id="resendLink">Didn't receive a code? Resend <span id="countdown">(30)</span></a>
        </div>

        <div class="back-link">
            <a href="{{ route('login') }}">Back to sign-in</a>
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
        const verifyBtn = document.getElementById('verifyBtn');
        const verificationCode = document.getElementById('verificationCode');
        let currentIndex = 0;

        codeInputs.forEach((input, index) => {
            input.addEventListener('input', function(e) {
                const value = e.target.value;
                
                // Only allow numbers
                if (!/^\d$/.test(value)) {
                    e.target.value = '';
                    return;
                }

                // Add filled class
                e.target.classList.add('filled');

                // Move to next input
                if (value && index < codeInputs.length - 1) {
                    codeInputs[index + 1].focus();
                }

                // Check if all inputs are filled
                checkAllFilled();
            });

            input.addEventListener('keydown', function(e) {
                // Handle backspace
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
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
                
                checkAllFilled();
            });
        });

        function checkAllFilled() {
            const allFilled = Array.from(codeInputs).every(input => input.value);
            if (allFilled) {
                // Combine all values
                const code = Array.from(codeInputs).map(input => input.value).join('');
                verificationCode.value = code;
                
                // Automatically submit the form when all 6 digits are entered
                setTimeout(() => {
                    document.getElementById('verificationForm').submit();
                }, 100);
            } else {
                verifyBtn.style.display = 'none';
            }
        }

        // Verification form handling - direct submit to dashboard
        document.getElementById('verificationForm').addEventListener('submit', function(e) {
            // Let the form submit naturally to dashboard
            // The dashboard route will handle verification
        });

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

        // Display session messages
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#9333EA'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonColor: '#9333EA'
            });
        @endif

    </script>
</body>
</html>
