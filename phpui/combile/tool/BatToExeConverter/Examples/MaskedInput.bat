@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /showself

%extd% /maskedinput

if "%result%"=="" (exit) else (set string="%result%")

%extd% /messagebox Result %string%
