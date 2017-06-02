@echo off

prompt -$g  
title QueryPHP PHP-GTK 调式保持工具 

if exist %PHPUI_PATH% (
        echo  PHPGTK 未安装或者PHPGTK_ROOT 环境变量未设置
        pause
        goto :eof
)
goto menu   
  
:menu   
echo ^ 欢迎使用 QueryPHP PHP-GTK 调式保持工具   
echo ^--------------------------------------------   
echo ^ 本工具可以帮助你调式 PHP-GTK 开发过程中的错误
echo ^ 高性能 PHP 开发框架尽在 www.queryphp.com (Query Yet Simple)
echo ^----------------------   
echo ^  1 调试（默认）  2 执行  0 退出   
echo ^----------------------   
set /p input=-^> 请选择：   
echo.   
if "%input%"== "0" goto end  
if "%input%"== "1" goto debug   
if "%input%"== "2" goto run 
if "%input%"== "" goto debug   
goto end  
  
:debug 
%PHPUI_PATH%\php-win.exe start.phpui
echo ^上面为 PHP-GTK 调式的信息   
echo ^----------------------   
echo ^  1 调试（默认）  2 执行  0 退出          
echo ^----------------------   
set /p input=-^>请选择 :   
if "%input%"=="0" goto end  
if "%input%"=="1" goto debug   
if "%input%"=="2" goto run   
if "%input%"=="" goto debug   
goto end  

:run   
%PHPUI_PATH%\php.exe start.phpui
echo ^----------------------   
echo ^  1 调试（默认）  2 执行  0 退出          
echo ^----------------------   
set /p nSelect=-^>请选择 :   
if "%input%"=="0" goto end  
if "%input%"=="1" goto debug   
if "%input%"=="2" goto run 
if "%input%"=="" goto debug   
goto end  
  
:end  
prompt   
popd