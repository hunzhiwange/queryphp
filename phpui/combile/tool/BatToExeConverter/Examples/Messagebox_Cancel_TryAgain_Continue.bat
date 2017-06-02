@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /messagebox "" "Cancel, Try again, Continue" 6

IF %result% EQU 2 %extd% /messagebox Result Cancel

IF %result% EQU 10 %extd% /messagebox Result "Try again"

IF %result% EQU 11 %extd% /messagebox Result Continue