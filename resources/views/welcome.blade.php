<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #0B1426;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Winter Night Background */
        .winter-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .night-sky {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(ellipse at center, #1a2332 0%, #0B1426 70%);
            z-index: 1;
        }

        .stars {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
        }

        .star {
            position: absolute;
            background: white;
            border-radius: 50%;
            animation: twinkle 3s infinite;
        }

        .star:nth-child(1) { top: 10%; left: 20%; width: 2px; height: 2px; animation-delay: 0s; }
        .star:nth-child(2) { top: 15%; left: 80%; width: 1px; height: 1px; animation-delay: 0.5s; }
        .star:nth-child(3) { top: 25%; left: 40%; width: 3px; height: 3px; animation-delay: 1s; }
        .star:nth-child(4) { top: 30%; left: 70%; width: 1px; height: 1px; animation-delay: 1.5s; }
        .star:nth-child(5) { top: 35%; left: 10%; width: 2px; height: 2px; animation-delay: 2s; }
        .star:nth-child(6) { top: 5%; left: 60%; width: 1px; height: 1px; animation-delay: 2.5s; }
        .star:nth-child(7) { top: 20%; left: 90%; width: 2px; height: 2px; animation-delay: 0.8s; }
        .star:nth-child(8) { top: 8%; left: 30%; width: 1px; height: 1px; animation-delay: 1.2s; }

        @keyframes twinkle {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 1; }
        }

        .snow-road {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 60%;
            background: linear-gradient(to top, #1a2332 0%, #2a3441 30%, #3a4451 100%);
            z-index: 3;
        }

        .road {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 20%;
            height: 100%;
            background: linear-gradient(to top, #0B1426 0%, #1a2332 50%, #2a3441 100%);
            z-index: 4;
        }

        .road::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 2px;
            height: 100%;
            background: repeating-linear-gradient(
                to bottom,
                transparent 0px,
                transparent 20px,
                #4a5568 20px,
                #4a5568 40px
            );
        }

        .snow-banks {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 40%;
            background: linear-gradient(to top, #1a2332 0%, #2a3441 50%, #3a4451 100%);
            z-index: 3;
        }

        .snow-banks::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(ellipse at 20% 80%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 70%, rgba(255,255,255,0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 90%, rgba(255,255,255,0.06) 0%, transparent 50%);
        }

        .trees {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 80%;
            z-index: 5;
        }

        .tree {
            position: absolute;
            bottom: 0;
            background: linear-gradient(to top, #1a2332 0%, #2a3441 50%, #3a4451 100%);
        }

        .tree-left {
            left: 0;
            width: 15%;
            height: 100%;
            clip-path: polygon(0% 100%, 20% 20%, 40% 30%, 60% 15%, 80% 25%, 100% 10%, 100% 100%);
        }

        .tree-right {
            right: 0;
            width: 15%;
            height: 100%;
            clip-path: polygon(0% 10%, 20% 25%, 40% 15%, 60% 30%, 80% 20%, 100% 100%, 0% 100%);
        }

        .tree-center-left {
            left: 25%;
            width: 12%;
            height: 90%;
            clip-path: polygon(0% 100%, 30% 25%, 50% 35%, 70% 20%, 100% 30%, 100% 100%);
        }

        .tree-center-right {
            right: 25%;
            width: 12%;
            height: 90%;
            clip-path: polygon(0% 30%, 30% 20%, 50% 35%, 70% 25%, 100% 100%, 0% 100%);
        }

        .car {
            position: absolute;
            bottom: 20%;
            left: 50%;
            transform: translateX(-50%);
            width: 4%;
            height: 8%;
            background: #dc2626;
            border-radius: 2px;
            z-index: 6;
        }

        .car::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #dc2626 0%, #ef4444 50%, #dc2626 100%);
            border-radius: 2px;
        }

        .brake-lights {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, #ff0000 0%, #dc2626 70%, transparent 100%);
            border-radius: 2px;
            animation: brakeGlow 2s infinite;
        }

        @keyframes brakeGlow {
            0%, 100% { opacity: 0.8; }
            50% { opacity: 1; }
        }

        .snow-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 7;
            pointer-events: none;
        }

        .snowflake {
            position: absolute;
            color: white;
            font-size: 12px;
            animation: fall linear infinite;
        }

        .snowflake:nth-child(1) { left: 10%; animation-duration: 8s; animation-delay: 0s; }
        .snowflake:nth-child(2) { left: 20%; animation-duration: 6s; animation-delay: 1s; }
        .snowflake:nth-child(3) { left: 30%; animation-duration: 7s; animation-delay: 2s; }
        .snowflake:nth-child(4) { left: 40%; animation-duration: 9s; animation-delay: 0.5s; }
        .snowflake:nth-child(5) { left: 50%; animation-duration: 5s; animation-delay: 1.5s; }
        .snowflake:nth-child(6) { left: 60%; animation-duration: 8s; animation-delay: 3s; }
        .snowflake:nth-child(7) { left: 70%; animation-duration: 6s; animation-delay: 0.8s; }
        .snowflake:nth-child(8) { left: 80%; animation-duration: 7s; animation-delay: 2.5s; }
        .snowflake:nth-child(9) { left: 90%; animation-duration: 9s; animation-delay: 1.2s; }

        @keyframes fall {
            0% { transform: translateY(-100vh) rotate(0deg); opacity: 1; }
            100% { transform: translateY(100vh) rotate(360deg); opacity: 0; }
        }

            /* Welcome Card */
            .welcome-container {
                position: relative;
                z-index: 10;
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                border-radius: 24px;
                padding: 48px 40px;
                width: 100%;
                max-width: 500px;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
                margin: 20px;
                text-align: center;
            }

            .welcome-title {
                font-size: 36px;
                font-weight: 700;
                color: #FFFFFF;
                margin-bottom: 16px;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            }

            .welcome-subtitle {
                font-size: 18px;
                color: #E5E7EB;
                margin-bottom: 40px;
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
            }

            .user-info {
                background: rgba(255, 255, 255, 0.15);
                border-radius: 16px;
                padding: 24px;
                margin-bottom: 32px;
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            .user-name {
                font-size: 24px;
                font-weight: 600;
                color: #FFFFFF;
                margin-bottom: 8px;
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
            }

            .user-email {
                font-size: 16px;
                color: #D1D5DB;
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
            }

            .action-buttons {
                display: flex;
                gap: 16px;
                justify-content: center;
                flex-wrap: wrap;
            }

            .btn {
                padding: 12px 24px;
                border-radius: 12px;
                font-size: 16px;
                font-weight: 600;
                text-decoration: none;
                transition: all 0.3s ease;
                cursor: pointer;
                border: none;
            }

            .btn-primary {
                background: #DC2626;
                color: white;
                box-shadow: 0 4px 16px rgba(220, 38, 38, 0.3);
            }

            .btn-primary:hover {
                background: #B91C1C;
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
            }

            .btn-secondary {
                background: rgba(255, 255, 255, 0.2);
                color: #FFFFFF;
                border: 1px solid rgba(255, 255, 255, 0.3);
            }

            .btn-secondary:hover {
                background: rgba(255, 255, 255, 0.3);
                transform: translateY(-2px);
            }

            .auth-links {
                margin-top: 24px;
                display: flex;
                gap: 16px;
                justify-content: center;
                flex-wrap: wrap;
            }

            .auth-link {
                color: #FFFFFF;
                text-decoration: none;
                font-weight: 600;
                padding: 8px 16px;
                border-radius: 8px;
                transition: all 0.3s ease;
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
            }

            .auth-link:hover {
                background: rgba(255, 255, 255, 0.2);
                text-decoration: none;
            }

            /* Responsive Design */
            @media (max-width: 480px) {
                .welcome-container {
                    margin: 10px;
                    padding: 32px 24px;
                }
                
                .welcome-title {
                    font-size: 28px;
                }

                .action-buttons {
                    flex-direction: column;
                }

                .auth-links {
                    flex-direction: column;
                }
            }
            </style>
    </head>
    <body>
        <!-- Winter Night Background -->
        <div class="winter-bg">
            <div class="night-sky"></div>
            <div class="stars">
                <div class="star"></div>
                <div class="star"></div>
                <div class="star"></div>
                <div class="star"></div>
                <div class="star"></div>
                <div class="star"></div>
                <div class="star"></div>
                <div class="star"></div>
            </div>
            <div class="snow-road"></div>
            <div class="snow-banks"></div>
            <div class="road"></div>
            <div class="trees">
                <div class="tree tree-left"></div>
                <div class="tree tree-right"></div>
                <div class="tree tree-center-left"></div>
                <div class="tree tree-center-right"></div>
            </div>
            <div class="car">
                <div class="brake-lights"></div>
            </div>
            <div class="snow-particles">
                <div class="snowflake">❄</div>
                <div class="snowflake">❅</div>
                <div class="snowflake">❆</div>
                <div class="snowflake">❄</div>
                <div class="snowflake">❅</div>
                <div class="snowflake">❆</div>
                <div class="snowflake">❄</div>
                <div class="snowflake">❅</div>
                <div class="snowflake">❆</div>
            </div>
        </div>

        <!-- Welcome Content -->
        <div class="welcome-container">
                    @auth
                <h1 class="welcome-title">Welcome Back!</h1>
                <p class="welcome-subtitle">You're successfully logged in</p>
                
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-email">{{ Auth::user()->email }}</div>
                </div>

                <div class="action-buttons">
                    <button class="btn btn-primary" onclick="showSuccess()">Get Started</button>
                    <a href="{{ route('logout') }}" class="btn btn-secondary" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <h1 class="welcome-title">Welcome!</h1>
                <p class="welcome-subtitle">Please log in to access your account</p>
                
                <div class="auth-links">
                    <a href="{{ route('login') }}" class="auth-link">Login</a>
                    <a href="{{ route('register') }}" class="auth-link">Register</a>
                </div>
            @endauth
        </div>

        <script>
            function showSuccess() {
                Swal.fire({
                    icon: 'success',
                    title: 'Welcome!',
                    text: 'You are now logged in successfully.',
                    confirmButtonColor: '#DC2626'
                });
            }

            // Display any session messages
            @if (session('status'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('status') }}',
                    confirmButtonColor: '#DC2626'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#DC2626'
                });
        @endif
        </script>
    </body>
</html>