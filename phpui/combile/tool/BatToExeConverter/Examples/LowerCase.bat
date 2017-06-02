@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /inputbox "LowerCase" "Enter an uppercase string in the textbox below" "STRING"

if "%result%"=="" (exit) else (set string="%result%")

%extd% /lowercase %string%

if "%result%"=="" (exit) else (set lower="%result%")

%extd% /messagebox Result %lower%
