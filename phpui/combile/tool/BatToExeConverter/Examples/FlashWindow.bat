@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /inputbox "FlashWindow" "Enter the title of a visible window" ""

if "%result%"=="" (exit) else (set window="%result%")

%extd% /flashwindow %window% 60 1000 FLASHW_ALL