<?php 

exit();

$source = '/data/codes/queryyetsimple/queryyetsimple';

$replaceFind = <<<eot
 * ##########################################################
 * #   ____                          ______  _   _ ______   #
 * #  /     \       ___  _ __  _   _ | ___ \| | | || ___ \  #
 * # |   (  ||(_)| / _ \| '__|| | | || |_/ /| |_| || |_/ /  #
 * #  \____/ |___||  __/| |   | |_| ||  __/ |  _  ||  __/   #
 * #       \__   | \___ |_|    \__  || |    | | | || |      #
 * #     Query Yet Simple      __/  |\_|    |_| |_|\_|      #
 * #                          |___ /  Since 2010.10.03      #
 * ##########################################################
eot;

$replaceTo = <<<eot
 * _____________                           _______________
 *  ______/     \__  _____  ____  ______  / /_  _________
 *   ____/ __   / / / / _ \/ __`\/ / __ \/ __ \/ __ \___
 *    __/ / /  / /_/ /  __/ /  \  / /_/ / / / / /_/ /__
 *      \_\ \_/\____/\___/_/   / / .___/_/ /_/ .___/
 *         \_\                /_/_/         /_/
eot;

set_time_limit(300);

function listDirectory($sPath, Closure $cal, $arrFilter = [])
{
    $arrFilter = array_merge([
        '.svn',
        '.git',
        'node_modules',
        '.gitkeep'
    ], $arrFilter);

    if (! is_dir($sPath)) {
        return;
    }

    $objDir = new DirectoryIterator($sPath);
    foreach ($objDir as $objFile) {
        if ($objFile->isDot() || in_array($objFile->getFilename(), $arrFilter)) {
            continue;
        }

        call_user_func($cal, $objFile);
        if ($objFile->isDir()) {
            listDirectory($objFile->getPath() . '/' . $objFile->getFilename(), $cal, $arrFilter);
        }
    }
}

listDirectory($source,function($file) use($replaceFind, $replaceTo){
    if ($file->isFile() && $file->getExtension() == 'zep') {
        $file = $file->getPath() . '/' . $file->getFilename();

        $content  = file_get_contents($file);

        if (strpos($content, $replaceFind) !== false) {
            $content = str_replace($replaceFind,$replaceTo,$content);
            //echo $content;
            echo $file .'<br/>';

            file_put_contents($file,$content);

            //exit();
        }
    }
});