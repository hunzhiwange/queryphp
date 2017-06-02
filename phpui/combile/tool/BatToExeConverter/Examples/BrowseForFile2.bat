@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /browseforfile "Browse for a file" "default.bat" "EXE (*.exe)|*.exe|BAT (*.bat)|*.bat" "1"

if "%result%"=="" (exit) else (set file="%result%")

%extd% /messagebox Result %file%