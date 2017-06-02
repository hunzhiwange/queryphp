@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

cd %~dp0

%extd% /messagebox  "Downloader" "This example will download 'Bat To Exe Converter' from 'http://www.f2ko.de/downloads/Bat_To_Exe_Converter.zip' and save it in the current directory." 1

IF %result% EQU 1  (
	%extd% /download "http://www.f2ko.de/downloads/Bat_To_Exe_Converter.zip" "Bat_To_Exe_Converter.zip"
) ELSE (
       exit
)

IF %result% EQU 0  (
	%extd% /messagebox Error "Download failed" 16
) ELSE (
	%extd% /messagebox Done "Download succeeded"
)