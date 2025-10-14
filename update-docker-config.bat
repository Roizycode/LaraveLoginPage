@echo off
echo ========================================
echo    Docker Configuration Update
echo ========================================
echo.

echo This script will help you update your Docker configuration.
echo.

echo Step 1: Get your GitHub username
echo ========================================
echo 1. Go to your GitHub profile: https://github.com/settings/profile
echo 2. Your username is shown at the top
echo 3. Or check your repository URL: https://github.com/USERNAME/REPO-NAME
echo.

set /p github_username="Enter your GitHub username: "

if "%github_username%"=="" (
    echo Error: Username cannot be empty!
    pause
    exit /b 1
)

echo.
echo Step 2: Updating render.yaml...
echo ========================================

powershell -Command "(Get-Content 'render.yaml') -replace 'YOUR_GITHUB_USERNAME', '%github_username%' | Set-Content 'render.yaml'"

echo ✅ Updated render.yaml with your GitHub username: %github_username%
echo.

echo Step 3: Your Docker repository will be:
echo ========================================
echo ghcr.io/%github_username%/laravel-login-app
echo.

echo Step 4: Next steps:
echo ========================================
echo 1. Push your code to GitHub
echo 2. Go to Actions tab in your repository
echo 3. The Docker build will start automatically
echo 4. Once complete, your image will be available at:
echo    ghcr.io/%github_username%/laravel-login-app:latest
echo 5. Deploy to Render using the updated render.yaml
echo.

echo 🎉 Configuration updated successfully!
echo.
pause
