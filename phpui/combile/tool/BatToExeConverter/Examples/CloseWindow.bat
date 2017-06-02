@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /inputbox "CloseWindow example" "Enter the title of the window you would like to close" ""

if "%result%"=="" (exit) else (set window="%result%")

%extd% /closewindow %window%