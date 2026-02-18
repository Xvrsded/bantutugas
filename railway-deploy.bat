@echo off
REM Railway Setup Script for Windows PowerShell

echo ===================================
echo Bantu Tugas - Railway Deploy Setup
echo ===================================
echo.

REM Check git status
echo [1/5] Checking git repository...
git status

echo.
echo [2/5] Staging all files...
git add .

echo.
echo [3/5] Creating initial commit...
git commit -m "Initial commit: Bantu Tugas Platform with full database integration"

echo.
echo ===================================
echo NEXT STEPS:
echo ===================================
echo.
echo 1. Create GitHub repository:
echo    - Go to https://github.com/new
echo    - Create repository named 'bantutugas'
echo    - Do NOT initialize with README
echo.
echo 2. Add remote and push:
echo    - Change USERNAME to your GitHub username
echo    - Run in PowerShell:
echo.
echo    git remote add origin https://github.com/USERNAME/bantutugas.git
echo    git branch -M main
echo    git push -u origin main
echo.
echo 3. Go to Railway:
echo    - Open https://railway.app
echo    - Sign up or login
echo    - Create new project from GitHub
echo    - Select your 'bantutugas' repository
echo.
echo 4. Configure Environment Variables in Railway:
echo    - APP_KEY=base64:EC6MwBEixLVgQeJje4mEBkcp7GHIaHTitmYpIEGtQ4I=
echo    - APP_ENV=production
echo    - APP_DEBUG=false
echo    - DB_* variables (Railway MySQL will provide these)
echo.
echo 5. Deploy!
echo.
echo ===================================
echo For detailed guide, see RAILWAY_SETUP.md
echo ===================================
