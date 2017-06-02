@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /browseforfile "Select an exe file" "" "Exe (*.exe)|*.exe"

if "%result%"=="" (exit) else (set file="%result%")

%extd% /savefiledialog "Save file as" "Admin.exe" "Exe (*.exe)|*.exe"

if "%result%"=="" (exit) else (set save="%result%")

%extd% /makeadmin %file% %save%

if %result% EQU 0  (
	%extd% /messagebox "" Failed 16
) else (
	%extd% /messagebox "" "Done"
)
