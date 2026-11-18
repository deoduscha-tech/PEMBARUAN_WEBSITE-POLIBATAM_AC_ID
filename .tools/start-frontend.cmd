@echo off
cd /d "c:\laragon\www\PEMBARUAN_WEBSITE-POLIBATAM_AC_ID\frontend"
call npx next dev --webpack -p 3000 >> "c:\laragon\www\PEMBARUAN_WEBSITE-POLIBATAM_AC_ID\.tools\frontend.log" 2>&1
