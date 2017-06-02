@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /is64bit

IF %result% EQU 1  (
	%extd% /messagebox Result "Your operating system is 64 Bit"
) ELSE (
	%extd% /messagebox Result "Your operating system is 32 Bit"
)