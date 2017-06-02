@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /browseforfile "Choose a file" "" "All Files (*.*)|*.*"

if "%result%"=="" (exit) else (set file="%result%")

%extd% /sha1 %file%

if "%result%"=="" (exit) else (set sha1="%result%")

%extd% /messagebox Result %sha1%