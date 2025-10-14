@echo off
echo ========================================
echo    Docker Repository Setup Script
echo ========================================
echo.

echo Choose your Docker registry:
echo 1. GitHub Container Registry (ghcr.io) - Recommended
echo 2. Docker Hub
echo 3. Both
echo.
set /p choice="Enter your choice (1-3): "

if "%choice%"=="1" goto github_setup
if "%choice%"=="2" goto dockerhub_setup
if "%choice%"=="3" goto both_setup
goto invalid_choice

:github_setup
echo.
echo ========================================
echo   GitHub Container Registry Setup
echo ========================================
echo.
echo 1. Go to your GitHub repository
echo 2. Click Settings ^> Secrets and variables ^> Actions
echo 3. No additional secrets needed - uses GITHUB_TOKEN automatically
echo.
echo Your Docker images will be available at:
echo ghcr.io/YOUR_GITHUB_USERNAME/laravel-login-app
echo.
echo Next steps:
echo 1. Update render-docker.yaml with your GitHub username
echo 2. Push your code to trigger the build
echo.
goto end

:dockerhub_setup
echo.
echo ========================================
echo        Docker Hub Setup
echo ========================================
echo.
echo 1. Create account at https://hub.docker.com
echo 2. Create a new repository named 'laravel-login-app'
echo 3. Go to Account Settings ^> Security ^> New Access Token
echo 4. Create a new access token with 'Read, Write, Delete' permissions
echo.
echo 5. Go to your GitHub repository:
echo    Settings ^> Secrets and variables ^> Actions
echo    Add these secrets:
echo    - DOCKERHUB_USERNAME: Your Docker Hub username
echo    - DOCKERHUB_TOKEN: Your Docker Hub access token
echo.
echo Your Docker images will be available at:
echo YOUR_DOCKERHUB_USERNAME/laravel-login-app
echo.
goto end

:both_setup
echo.
echo ========================================
echo     Both Registries Setup
echo ========================================
echo.
echo Follow both GitHub Container Registry AND Docker Hub setup steps above.
echo.
goto end

:invalid_choice
echo Invalid choice. Please run the script again.
goto end

:end
echo.
echo ========================================
echo   Workflow Files Created:
echo ========================================
echo - .github/workflows/docker-build.yml (GitHub Container Registry)
echo - .github/workflows/docker-hub.yml (Docker Hub)
echo - .github/workflows/render-deploy.yml (Auto-deploy to Render)
echo - render-docker.yaml (Render config for Docker images)
echo.
echo Press any key to exit...
pause >nul
