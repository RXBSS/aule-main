@echo off
echo Orthor aktualisieren...

REM Orthor aktualisieren
cd orthor
git stash
git pull

call update %*

cd..

call gulp copy
