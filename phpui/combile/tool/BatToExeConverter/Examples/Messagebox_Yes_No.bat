@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /messagebox  "" "Yes, No" 4

IF %result% EQU 6 %extd% /messagebox Result Yes

IF %result% EQU 7 %extd% /messagebox Result No