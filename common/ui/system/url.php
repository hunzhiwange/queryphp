<?php
/*
 * This file is part of the ************************ package.
 * ##########################################################
 * #   ____                          ______  _   _ ______   #
 * #  /     \       ___  _ __  _   _ | ___ \| | | || ___ \  #
 * # |   (  ||(_)| / _ \| '__|| | | || |_/ /| |_| || |_/ /  #
 * #  \____/ |___||  __/| |   | |_| ||  __/ |  _  ||  __/   #
 * #       \__   | \___ |_|    \__  || |    | | | || |      #
 * #     Query Yet Simple      __/  |\_|    |_| |_|\_|      #
 * #                          |___ /  Since 2010.10.03      #
 * ##########################################################
 * 
 * The PHP Framework For Code Poem As Free As Wind. <Query Yet Simple>
 * (c) 2010-2018 http://queryphp.com All rights reserved.
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * url 跳转模版
 *
 * @author Xiangmin Liu <635750556@qq.com>
 * @package $$
 * @since 2017.01.02
 * @version 1.0
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo $sMsg;?></title>
        <style type="text/css">
        .queryphp-message-container {
            font-family: "Microsoft YaHei", FreeSans, Arimo, "Droid Sans",
                "wenquanyi micro hei", "Hiragino Sans GB", "Hiragino Sans GB W3",
                FontAwesome, sans-serif;
        }

        .queryphp-message-container .queryphp-message-title {
            display: block;
            margin: 20px 0 0px 10px;
            font-size: 100px;
            font-weight: bold;
            color: #838FA1
        }

        .queryphp-message-container .queryphp-message-subtitle {
            margin: 10px 0 20px 18px;
            font-size: 25px;
            font-weight: bold;
            color: #dce2ec;
            word-wrap: break-word
        }
        </style>
        <script type="text/javascript">
        function run(){
            var s=document.getElementById( "sec" );
            if( s.innerHTML == 0 ) {
                return false;
            }
            s.innerHTML = s.innerHTML*1 - 1;
        }
        window.setInterval("run();", 1000);
        </script>
    </head>
    <body>
        <div class="queryphp-message-container">
            <div class="queryphp-message-title">
                <span id="sec"><?php echo $nTime; ?></span> Seconds
            </div>
            <div class="queryphp-message-subtitle"><?php echo $sMsg; ?></div>
        </div>
    </body>
</html>