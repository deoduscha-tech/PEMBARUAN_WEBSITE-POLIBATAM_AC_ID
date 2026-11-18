

@echo off
cd /d "c:\laragon\www\PEMBARUAN_WEBSITE-POLIBATAM_AC_ID\backend"
php artisan serve --host=127.0.0.1 --port=8000 >> "c:\laragon\www\PEMBARUAN_WEBSITE-POLIBATAM_AC_ID\.tools\backend.log" 2>&1
