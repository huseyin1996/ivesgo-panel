@echo off
rem ==========================================================
rem  start_go2rtc.bat
rem  go2rtc'yi baslatir; kapanirsa 3 saniye sonra yeniden acar.
rem  Bu dosya, go2rtc.exe ve go2rtc.yaml ile AYNI klasorde olmali
rem  (ornek: C:\go2rtc). Web kok dizinine KOYMAYIN.
rem ==========================================================
setlocal
cd /d "%~dp0"

if not exist "go2rtc.exe" goto noexe
if not exist "go2rtc.yaml" goto noyaml

echo go2rtc basliyor. Durdurmak icin bu pencereyi kapatin.
echo Test sayfasi (tarayicida acin): http://localhost:1984/

:loop
go2rtc.exe
echo [%date% %time%] go2rtc durdu. 3 sn sonra yeniden baslatilacak...
ping -n 4 127.0.0.1 >nul
goto loop

:noexe
echo go2rtc.exe bulunamadi. https://github.com/AlexxIT/go2rtc/releases adresinden
echo go2rtc_win64.zip dosyasini indirip icindeki go2rtc.exe'yi bu klasore koyun.
pause
exit /b 1

:noyaml
echo go2rtc.yaml bulunamadi. Dosyayi bu klasore koyun.
pause
exit /b 1
