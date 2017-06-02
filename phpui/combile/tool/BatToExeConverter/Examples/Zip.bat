@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /browseforfile "Select a file to zip" "" "All Files (*.*)|*.*"

if "%result%"=="" (exit) else (set file="%result%")

%extd% /savefiledialog "Save file as" "MyZipfile.zip" "All Files (*.*)|*.*"

if "%result%"=="" (exit) else (set save="%result%")

%extd% /zip %file% %save%