@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /messagebox "Info" "Your exe filename is: %b2eprogramfilename%"

%extd% /messagebox "Info" "It's stored in: %b2eprogrampathname%"

%extd% /messagebox "Info" "The current working directory is: %cd%"

%extd% /messagebox "Info" "Number of files included: %b2eincfilecount%"

if %b2eincfilecount% GTR 0  (

	%extd% /messagebox "Info" "Include files are stored in: %b2eincfilepath%"
	%extd% /messagebox "Info" "The First included file is: %b2eincfile1%"

if %b2eincfilecount% GTR 1  (

	%extd% /messagebox "Info" "The second file is: %b2eincfile2%"

)


)