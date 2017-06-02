@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /browseforfolder "Browse for a folder" "c:\"

if "%result%"=="" (exit) else (set folder="%result%")

%extd% /messagebox Result %folder%