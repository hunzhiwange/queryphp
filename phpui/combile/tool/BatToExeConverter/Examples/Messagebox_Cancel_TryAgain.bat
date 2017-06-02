@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /messagebox "" "Try again or Cancel" 5

IF %result% EQU 4 %extd% /messagebox Result "Try again"

IF %result% EQU 2 %extd% /messagebox Result "Cancel"