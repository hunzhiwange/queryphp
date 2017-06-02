@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /inputbox "MinimizeWindow" "Enter the title of the window you would like to minimize" ""

if "%result%"=="" (exit) else (set window="%result%")

%extd% /minimizewindow %window%