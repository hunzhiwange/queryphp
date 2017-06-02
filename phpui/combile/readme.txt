（1）打包程序会检测 PHPGTK_ROOT 来判断是否安装了 PHP-GTK

默认将 php-win.exe 通过 tool\ResHacker 3.5 将图片替换一下得到的文件 run.exe（当前是一只牛的样子）。

如果你需要自己的图标，请将 php-win.exe 生成你的图标，并且替换一下。

本文件将被自动拷贝 run.exe 到 php-gtk 运行目录，方便打开的 PHP-GTK 应用具有自定义图标。

（2）combile.bat 打包 combile.exe 后，名字可以重命名，然后拷贝到 start.gtk 所在的目录。