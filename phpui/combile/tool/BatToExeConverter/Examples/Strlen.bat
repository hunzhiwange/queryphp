@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /inputbox "Strlen" "Enter a string to calculate its length" ""

if "%result%"=="" (exit) else (set string="%result%")

%extd% /strlen %string%

%extd% /messagebox Result "%result%"