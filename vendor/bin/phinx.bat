@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../robmorgan/phinx/bin/phinx
php "%BIN_TARGET%" %*
