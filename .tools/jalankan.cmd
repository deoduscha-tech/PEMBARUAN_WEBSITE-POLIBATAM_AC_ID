@echo off
setlocal
title P2M Polibatam - Dev Server + Tunnel
cd /d "%~dp0"

echo ============================================
echo   MENYALAKAN WEBSITE P2M POLIBATAM
echo ============================================
echo.

if not exist "cloudflared.exe" (
  echo [X] cloudflared.exe tidak ditemukan di folder .tools
  echo     Unduh dulu: https://github.com/cloudflare/cloudflared/releases/latest/download/cloudflared-windows-amd64.exe
  pause
  exit /b 1
)

echo [1/3] Menyalakan backend Laravel (port 8000)...
start "Laravel :8000" /min cmd /c ""%~dp0start-backend.cmd""
timeout /t 4 /nobreak >nul

echo [2/3] Menyalakan frontend Next.js (port 3000)...
start "Next.js :3000" /min cmd /c ""%~dp0start-frontend.cmd""
echo     Menunggu Next.js siap (sekitar 20-40 detik)...
timeout /t 30 /nobreak >nul

echo [3/3] Membuat tunnel Cloudflare...
del /q tunnel.log >nul 2>&1
echo.
echo ============================================
echo   TUNGGU LINK MUNCUL DI BAWAH INI
echo   (tekan Ctrl+C untuk mematikan semua)
echo ============================================
echo.

cloudflared.exe tunnel --url http://localhost:3000
