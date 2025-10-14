@echo off
echo ========================================
echo    Laravel Login App - GitHub Setup
echo ========================================
echo.
echo Step 1: Create a new repository on GitHub
echo 1. Go to https://github.com
echo 2. Click "+" then "New repository"
echo 3. Repository name: Laravel-Login-App
echo 4. Make it Public
echo 5. DON'T initialize with README, .gitignore, or license
echo 6. Click "Create repository"
echo.
echo Step 2: Copy the repository URL from GitHub
echo It should look like: https://github.com/YOUR_USERNAME/Laravel-Login-App.git
echo.
echo Step 3: Run this command with your repository URL:
echo git remote set-url origin YOUR_REPOSITORY_URL
echo git push -u origin main
echo.
pause
