@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /getcursorposx

set x=%result%

%extd% /getcursorposy

set y=%result%

%extd% /messagebox "Cursor coordinates" "X=%x% Y=%y%"