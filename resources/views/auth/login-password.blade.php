<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enter Password</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="/people.png">
    <style>
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
            padding: 20px;
        }
        body::before { content: ''; position: fixed; inset: 0; background: rgba(0,0,0,.6); z-index: 1; }
        .auth-container { position: relative; z-index: 10; background: #1f1f1f; border: 1px solid #333; border-radius: 16px; padding: 48px 40px; width: 100%; max-width: 450px; box-shadow: 0 8px 32px rgba(0,0,0,.5); }
        .auth-title { color: #fff; font-weight: 700; text-align: center; margin-bottom: 16px; font-size: 32px; }
        .auth-subtitle { display: none; }
        .form-label { color: #fff; font-size: 14px; font-weight: 500; margin-bottom: 8px; display: block; }
        .password-input-container { position: relative; }
        .form-input { width: 100%; padding: 12px 44px 12px 16px; border: 1px solid #404040; border-radius: 8px; background: #2a2a2a; font-size: 16px; color: #fff; outline: none; }
        .form-input:focus-visible { border-color: #9BD3DD; background: #333; box-shadow: 0 0 0 3px rgba(155,211,221,.2); }
        .password-toggle { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #9CA3AF; cursor: pointer; padding: 4px; border-radius: 6px; display: flex; align-items: center; justify-content: center; }
        .password-toggle svg { width: 20px; height: 20px; }
        .password-toggle .eye-open { display: block; }
        .password-toggle .eye-closed { display: none; }
        .password-toggle.show-password .eye-open { display: none; }
        .password-toggle.show-password .eye-closed { display: block; }
        .divider { display: flex; align-items: center; gap: 16px; color: #9CA3AF; margin: 24px 0; }
        .divider::before, .divider::after { content: ''; height: 1px; background: #404040; flex: 1; }
        .continue-btn { width: 100%; padding: 16px; background: #fff; color: #000; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; margin-top: 16px; }
        .secondary-btn { width: 100%; padding: 12px 16px; background: #fff; color: #000; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; position: relative; }
        .secondary-btn svg { width: 20px; height: 20px; color: #000; }
        .secondary-btn:disabled { opacity: 0.7; cursor: not-allowed; }
        .spinner { width: 20px; height: 20px; border: 2px solid #f3f3f3; border-top: 2px solid #000; border-radius: 50%; animation: spin 1s linear infinite; display: none; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        .back-link { text-align: center; margin-top: 16px; }
        .back-link a { color: #fff; text-decoration: none; font-size: 14px; font-weight: 500; }
		/* Match disabled visuals with secondary button */
		.continue-btn:disabled { opacity: 0.7; cursor: not-allowed; }
    </style>
    @php($loginEmail = session('login_email'))
    @if(!$loginEmail)
        <script>window.location.href = '{{ route('login') }}';</script>
    @endif
    @php($masked = $loginEmail ? preg_replace('/(^.).+(@.*$)/', '$1***$2', $loginEmail) : '')
    @php($display = $masked)
</head>
<body>
    <div class="auth-container">
        <h1 class="auth-title">Enter Your Password</h1>
        <form method="POST" action="{{ route('login.password.submit') }}" novalidate>
            @csrf
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="password-input-container">
                    <input type="password" name="password" class="form-input" placeholder="Enter your password" required>
                    <button type="button" id="passwordToggle" class="password-toggle" aria-label="Toggle password visibility">
                        <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" />
                            <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19" />
                            <path d="M14.12 14.12a3 3 0 0 1-4.24-4.24" />
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </div>
            </div>
			<button type="submit" class="continue-btn" id="continueBtn" style="display:flex;align-items:center;justify-content:center;gap:10px;">
				<div class="spinner" id="continueSpinner"></div>
				<span id="continueText">Continue</span>
			</button>
        </form>

        <div class="divider"><span>OR</span></div>
        
        <form method="POST" action="{{ route('login.send.code') }}" style="margin: 0;">
            @csrf
            <input type="hidden" name="email" value="{{ $loginEmail }}">
            <button type="submit" class="secondary-btn" id="emailCodeBtn" style="text-decoration:none; width: 100%;">
                <div class="spinner" id="emailCodeSpinner"></div>
                <svg id="emailCodeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                    <path d="m22 7-10 5L2 7"></path>
                </svg>
                <span id="emailCodeText">Continue with email code</span>
            </button>
        </form>
        <div class="back-link">
            <a href="{{ route('login') }}">Use a different email</a>
        </div>
    </div>

    @if ($errors->any())
        <script>
            Swal.fire({ icon: 'error', title: 'Error', text: @json($errors->first()), confirmButtonColor: '#87CEEB', confirmButtonText: 'OK' });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({ icon: 'error', title: 'Error', text: @json(session('error')), confirmButtonColor: '#87CEEB', confirmButtonText: 'OK' });
        </script>
    @endif

    <script>
        const toggleBtn = document.getElementById('passwordToggle');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function () {
                const input = document.querySelector('input[name="password"]');
                if (!input) return;
                const isPassword = input.getAttribute('type') === 'password';
                input.setAttribute('type', isPassword ? 'text' : 'password');
                this.classList.toggle('show-password', isPassword);
            });
        }

		// Password form spinner functionality
		const passwordForm = document.querySelector('form[action="{{ route('login.password.submit') }}"]');
		const continueBtn = document.getElementById('continueBtn');
		const continueSpinner = document.getElementById('continueSpinner');
		const continueText = document.getElementById('continueText');

		if (passwordForm && continueBtn) {
			passwordForm.addEventListener('submit', function() {
				continueSpinner.style.display = 'block';
				continueText.style.display = 'none';
				// Do not disable the button; allow interactions
			});
		}

		// Email code button spinner functionality
        const emailCodeForm = document.querySelector('form[action="{{ route('login.send.code') }}"]');
        const emailCodeBtn = document.getElementById('emailCodeBtn');
        const emailCodeSpinner = document.getElementById('emailCodeSpinner');
        const emailCodeIcon = document.getElementById('emailCodeIcon');
        const emailCodeText = document.getElementById('emailCodeText');

		if (emailCodeForm && emailCodeBtn) {
			emailCodeForm.addEventListener('submit', function(e) {
				// Show spinner and hide icon and text
				emailCodeSpinner.style.display = 'block';
				emailCodeIcon.style.display = 'none';
				emailCodeText.style.display = 'none';
				// Do not disable the button; allow interactions
			});
		}
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


