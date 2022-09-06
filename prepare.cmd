@echo off

echo.
echo Update orthor
echo -- Start
call update>NUL
echo -- Finshed
echo.
echo Git Pull
echo -- Start
call git pull>NUL
echo -- Finshed
echo.
echo NPM Install
echo -- Start
call npm install>NUL
echo -- Finshed
echo.
echo Reset Database
echo -- Start
call orthor db reset>NUL
echo -- Finshed
echo.

