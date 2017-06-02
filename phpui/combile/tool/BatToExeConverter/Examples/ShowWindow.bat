@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /inputbox "ShowWindow" "Enter the title of the hidden window you would like to show again" ""

if "%result%"=="" (exit) else (set window="%result%")

%extd% /showwindow %window%