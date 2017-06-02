@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /getsystemlanguage

if "%result%"=="" (exit) else (set syslang="%result%")

%extd% /messagebox "System Language" %syslang%