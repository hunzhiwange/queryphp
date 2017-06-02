@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /inputbox "" "Enter the text you want to be spoken in the box below" ""

if "%result%"=="" (exit) else (set string="%result%")

%extd% /speak %string% 2