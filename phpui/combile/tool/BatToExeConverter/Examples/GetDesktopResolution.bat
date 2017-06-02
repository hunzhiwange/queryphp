@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /getdesktopwidth

set width=%result%

%extd% /getdesktopheight

set height=%result%

%extd% /messagebox "Desktop resolution" "width=%width% height=%height%"