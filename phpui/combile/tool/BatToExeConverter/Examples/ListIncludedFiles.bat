@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /showself

SETLOCAL ENABLEDELAYEDEXPANSION

if %b2eincfilecount% GTR 0  (

for /l %%x in (1, 1, %b2eincfilecount%) do (

	echo !b2eincfilepath!!b2eincfile%%x!

)

) else (

	echo No files included

)

pause