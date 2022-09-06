@echo off
color 0A

REM Installation starten
echo.
echo installiere Template
echo ********************
echo.
echo Bitte vor der Installation die folgenden Vorrausetzungen prüfen:
echo.
echo - NPM installiert (Aktuelle Version)
echo - Composer installiert (Aktuelle Version)
echo - XAMPP installiert
echo - gd Extension in der php.ini muss aktiviert sein
echo. 

REM Abfrage ob mit der Installation fortgefahren werden soll
SET /P AREYOUSURE=Wollen Sie fortfahren? (Y/[N])?
IF /I "%AREYOUSURE%" NEQ "Y" GOTO END

REM Wenn fortgefahren werden soll
:GOON

REM Farbe setzen
color 01

REM Orthor Repository Clonen
rmdir orthor /s /q
git clone https://github.com/BurosystemhausSchafer/orthor

REM Installationsdatei aufrufen
call orthor\install.cmd

echo.
pause

GOTO FINAL

REM Wenn die Installation abgebrochen wurde
:END
color 0C
echo Installation wurde abgebrochen

REM Skip End und beende
:FINAL
