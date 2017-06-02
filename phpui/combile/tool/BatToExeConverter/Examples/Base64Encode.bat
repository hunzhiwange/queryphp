@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /browseforfile "Select a file" "" "All Files (*.*)|*.*"

if "%result%"=="" (exit) else (set file="%result%")

%extd% /savefiledialog "Save file as" "" "All Files (*.*)|*.*"

if "%result%"=="" (exit) else (set save="%result%")

%extd% /base64encode %file% %save%