@echo off
echo ========================================
echo    GitHub Repository Information
echo ========================================
echo.

echo Your GitHub repository will be used as the Docker repository name.
echo.
echo Current repository format: ghcr.io/OWNER/REPO-NAME
echo.
echo To find your repository name:
echo 1. Go to your GitHub repository
echo 2. Look at the URL: https://github.com/OWNER/REPO-NAME
echo 3. Your Docker repository will be: ghcr.io/OWNER/REPO-NAME
echo.

echo Example:
echo If your GitHub repo is: https://github.com/johnsmith/laravel-login-app
echo Your Docker repo will be: ghcr.io/johnsmith/laravel-login-app
echo.

echo ========================================
echo    Next Steps:
echo ========================================
echo.
echo 1. Push your code to GitHub
echo 2. Go to Actions tab in your GitHub repository
echo 3. The Docker build will start automatically
echo 4. Once complete, your Docker image will be available at:
echo    ghcr.io/YOUR_USERNAME/laravel-login-app
echo.
echo 5. To use in Render:
echo    - Update render-docker.yaml with your actual username
echo    - Replace YOUR_USERNAME with your GitHub username
echo.

echo Press any key to continue...
pause >nul
