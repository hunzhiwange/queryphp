@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /getuserlanguage

if "%result%"=="" (exit) else (set userlang="%result%")

%extd% /messagebox "User Language" %userlang%