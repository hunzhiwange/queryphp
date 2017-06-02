@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

cd %~dp0

%extd% /inputbox "Download 2" "Enter the Url you want to download" "http://www.f2ko.de/downloads/Bat_To_Exe_Converter.zip"

if "%result%"=="" (exit) else (set url="%result%")

%extd% /savefiledialog "Save file as" "Bat_To_Exe_Converter.zip" "All Files (*.*)|*.*"

if "%result%"=="" (exit) else (set file="%result%")

%extd% /download %url% %file%

if %result% EQU 0  (
	%extd% /messagebox Error "Download failed" 16
) ELSE (
	%extd% /messagebox Done "Download succeeded"
)