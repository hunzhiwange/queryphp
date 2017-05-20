<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
<<<queryphp
##########################################################
#   ____                          ______  _   _ ______   #
#  /     \       ___  _ __  _   _ | ___ \| | | || ___ \  #
# |   (  ||(_)| / _ \| '__|| | | || |_/ /| |_| || |_/ /  #
#  \____/ |___||  __/| |   | |_| ||  __/ |  _  ||  __/   #
#       \__   | \___ |_|    \__  || |    | | | || |      #
#     Query Yet Simple      __/  |\_|    |_| |_|\_|      #
#                          |___ /  Since 2010.10.03      #
##########################################################
queryphp;

/**
 * 系统致命错误模版
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.01.02
 * @version 1.0
 */
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Fatal Error (Query Yet Simple)</title>
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
    color: red
}

.queryphp-message-container .queryphp-message-subtitle {
    margin: 10px 0 20px 18px;
    font-size: 25px;
    font-weight: bold;
    color: #dce2ec
}

.queryphp-message-container .queryphp-message-content {
    margin: 20px 0 40px 20px;
    padding: 20px 20px 20px;
    width: 800px;
    border-radius: 10px;
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    background: red;
    font-size: 20px;
    color: #FFF
}
</style>
</head>
<body>
    <div class="queryphp-message-container">
        <div class="queryphp-message-title">Fatal Error</div>
        <div class="queryphp-message-subtitle">Please solve this problem
            before do next.</div>
        <div class="queryphp-message-content">
            <?php echo $sMessage; ?>
        </div>
    </div>

    <script type="text/javascript"
        src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.js"></script>
    <script type="text/javascript">
$(function(){
    var objMeta = $('meta'),objTitle=$('title'),objStyle=$('style'),objContainer = $('.queryphp-message-container');
    $('head').append(objMeta).append(objTitle).append(objStyle);
    $('body').html('').append(objContainer);
});
</script>

</body>
</html>