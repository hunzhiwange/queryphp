@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /browseforfile "Select a ZIP file" "" "ZIP (*.zip)|*.zip"

if "%result%"=="" (exit) else (set file="%result%")

%extd% /browseforfolder "Select a destination folder" "c:\"

if "%result%"=="" (exit) else (set folder="%result%")

%extd% /unzip %file% %folder%
