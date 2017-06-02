@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /messagebox "StrReplace"  "This example will search for the appearance 'sample' in the string 'a sample string' and replace it with 'replaced'"

%extd% /strreplace "a sample string" "sample" "replaced"

%extd% /messagebox Result "%result%"