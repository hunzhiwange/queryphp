@echo off

if "%b2eprogramfilename%"==""  (

	echo To see any results you need to convert this file into an exe
	pause
	goto :eof

)

%extd% /browseforfile "Select an exe file" "" "Exe (*.exe)|*.exe"

if "%result%"=="" (exit) else (set file="%result%")

%extd% /browseforfile "Select an icon file" "" "Ico (*.ico)|*.ico"

if "%result%"=="" (exit) else (set icon="%result%")

%extd% /savefiledialog "Save file as" "" "Exe (*.exe)|*.exe"

if "%result%"=="" (exit) else (set save="%result%")

%extd% /addextension %save% .exe 

if "%result%"=="" (exit) else (set save="%result%")

%extd% /changeexeicon %file% %save% %icon%

if %result% EQU 0  (
	%extd% /messagebox "" Failed 16
) else (
	%extd% /messagebox "" "Done"
)
