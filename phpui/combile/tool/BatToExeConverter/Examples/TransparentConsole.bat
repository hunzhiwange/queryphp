@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /showself

for /l %%x in (100,-1,0) do (

%extd% /sleep 5
%extd% /setconsoletransparency %%x

)

for /l %%x in (0,1,100) do (

%extd% /sleep 5
%extd% /setconsoletransparency %%x

)