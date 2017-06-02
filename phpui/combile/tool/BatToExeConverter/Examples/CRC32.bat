@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /browseforfile "Choose a file" "" "All Files (*.*)|*.*"

if "%result%"=="" (exit) else (set file="%result%")

%extd% /crc32 %file%

if "%result%"=="" (exit) else (set crc32="%result%")

%extd% /messagebox Result %crc32%