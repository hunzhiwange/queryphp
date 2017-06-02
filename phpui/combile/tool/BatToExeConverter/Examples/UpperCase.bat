@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /inputbox "Uppercase" "Enter a lowercase string in the textbox below" "string"

if "%result%"=="" (exit) else (set string="%result%")

%extd% /uppercase  %string%

if "%result%"=="" (exit) else (set upper="%result%")

%extd% /messagebox Result %upper%