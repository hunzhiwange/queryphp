@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /messagebox "StrPos" "This example will search for the appearance 'sample' in the string 'a sample string'"

%extd% /strpos "a sample string" "sample"

%extd% /messagebox Result "Found on position: %result%"