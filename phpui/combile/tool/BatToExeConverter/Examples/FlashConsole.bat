@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /showself

title Flash Caption

%extd% /flashconsole 60 1000 FLASHW_CAPTION

pause

title Flash Tray

%extd% /flashconsole 60 1000 FLASHW_TRAY

pause

title Flash All

%extd% /flashconsole 60 1000 FLASHW_ALL

pause