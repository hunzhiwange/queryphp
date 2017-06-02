@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /getcomputername

if "%result%"=="" (exit) else (set computername="%result%")

%extd% /messagebox "Computer name" %computername%