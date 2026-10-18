@echo off
REM ============================================================
REM  Jalankan website buatan sendiri (PEMBARUAN WEBSITE P2M)
REM
REM  Frontend Next.js: http://localhost:3000   <-- BUKA INI
REM  Backend Laravel : http://localhost:8000   (API)
REM  Website ASLI    : https://p2m.polibatam.ac.id  (jangan ini)
REM ============================================================

setlocal
set "ROOT=%~dp0"

echo.
echo [1/4] Menyiapkan database ...
if not exist "%ROOT%backend\database\database.sqlite" (
    type nul > "%ROOT%backend\database\database.sqlite"
)

echo [2/4] Memastikan aset CSS/JS backend siap ...
pushd "%ROOT%backend"
if not exist "%ROOT%backend\public\build\manifest.json" (
    echo      Build aset sekali saja, mohon tunggu ...
    call npm run build
) else (
    echo      Aset sudah siap.
)
popd

echo [3/4] Menyalakan backend Laravel (port 8000) ...
start "P2M - Backend Laravel" cmd /k "cd /d ""%ROOT%backend"" && php artisan migrate --force && php artisan serve --port=8000"

echo [4/4] Menyalakan frontend Next.js mode coding (port 3000) ...
start "P2M - Frontend Next.js" cmd /k "cd /d ""%ROOT%frontend"" && npm run dev"

echo.
echo Menunggu server siap ...
timeout /t 3 /nobreak >nul

echo Membuka browser ke website BUATAN SENDIRI ...
start "" "http://localhost:3000/hki"

echo.
echo ============================================================
echo  WEBSITE LIVE (buka ini)   : http://localhost:3000
echo  Halaman HKI               : http://localhost:3000/hki
echo  BACKEND API Laravel       : http://localhost:8000
echo  ADMIN                     : http://localhost:8000/admin
echo  WEBSITE ASLI (Polibatam)  : https://p2m.polibatam.ac.id
echo ============================================================
echo  Tutup jendela hitam untuk mematikan server.
echo ============================================================
endlocal
