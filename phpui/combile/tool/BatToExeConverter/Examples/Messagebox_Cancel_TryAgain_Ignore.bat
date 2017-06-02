@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /messagebox "" "Cancel ,Try again, Ignore" 2

IF %result% EQU 3 %extd% /messagebox Result Cancel

IF %result% EQU 4 %extd% /messagebox Result "Try again"

IF %result% EQU 5 %extd% /messagebox Result Ignore