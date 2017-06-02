@echo off

if not exist %PHPUI_PATH% (
        echo  PHPUI_PATH 环境变量未设置
        pause
        goto :eof
)

if "%b2eprogramfilename%"==""  (
	echo 想要查看结果请使用 BatToExeConverter 软件打包
	pause
	goto :eof
)

php.exe start.phpui