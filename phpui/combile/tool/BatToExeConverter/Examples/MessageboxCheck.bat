@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /messageboxcheck Title Message 0 {73E8105A-7AD2-4335-B694-94F837A38E79}