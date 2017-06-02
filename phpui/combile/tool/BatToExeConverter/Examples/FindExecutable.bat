@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /browseforfile "Browse for a file" "" "All Files (*.*)|*.*"

if "%result%"=="" (exit) else (set file="%result%")

%extd% /findexecutable %file%

if "%result%"==""  (

	%extd% /messagebox "" "Associated executable not found"
	exit

)

%extd% /messagebox Result "%result%"

