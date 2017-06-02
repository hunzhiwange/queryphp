@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /browseforfile "Browse for a file" "" "EXE (*.exe)|*.exe"

if "%result%"=="" (exit) else (set file="%result%")

%file% -b2edecompile