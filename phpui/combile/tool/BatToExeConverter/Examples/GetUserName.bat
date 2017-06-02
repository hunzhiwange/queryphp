@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /getusername

if "%result%"=="" (exit) else (set username="%result%")

%extd% /messagebox "User name" %username%