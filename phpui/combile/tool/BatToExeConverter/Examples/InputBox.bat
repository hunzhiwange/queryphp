@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /inputbox "Input Box" "Enter a string in the box below" ""

if "%result%"=="" (exit) else (set string="%result%")

%extd% /messagebox Result %string%
