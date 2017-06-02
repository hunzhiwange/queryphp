@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /messageboxcheck "" "Yes, No" 4 {5614464F-3829-4AA3-9F69-79A61E3191A3}

IF %result% EQU 6 %extd% /messagebox Result Yes

IF %result% EQU 7 %extd% /messagebox Result No