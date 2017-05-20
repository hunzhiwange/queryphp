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
 * 系统异常模版
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2016.11.19
 * @version 1.0
 */
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Exception (Query Yet Simple)</title>
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
    color: #FFD700
}

.queryphp-message-container .queryphp-message-subtitle {
    margin: 10px 0 20px 18px;
    font-size: 25px;
    font-weight: bold;
    color: #dce2ec
}

.queryphp-message-container .queryphp-message-content {
    margin: 20px 0 25px 20px;
    padding: 20px 20px 20px;
    width: 800px;
    border: 1px solid #faebcc;
    border-radius: 10px;
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    background: #fcf8e3;
    font-size: 20px;
    color: #8a6d3b
}

.queryphp-message-container .queryphp-message-detailtitle {
    margin: 5px 0 0px 20px;
    color: #484848;
    text-decoration: none;
    font-size: 1.5em;
    font-weight: bold
}

.queryphp-message-container .queryphp-message-detailcontent {
    margin: 0px 0 0px 20px;
    color: #999
}

.queryphp-message-container .queryphp-message-detailcontent ol {
    padding: 0;
    list-style: none;
    font-size: 15px;
    text-shadow: 0 1px 0 rgba(255, 255, 255, .5)
}

.queryphp-message-container .queryphp-message-detailcontent ol a {
    position: relative;
    display: block;
    margin: 15px 0;
    padding: 10px;
    width: 60%;
    border: 1px solid #ebebeb;
    border-radius: 0.3em;
    text-decoration: none;
    color: #666;
    border: 1px solid #ebebeb;
}

.queryphp-message-container .queryphp-message-detailcontent ol a span {
    color: #FFD700;
    font-weight: bold;
}

.queryphp-message-container .queryphp-message-argstitle {
    margin: 10px 0 10px 0px;
    color: #FFD700
}

.queryphp-message-container .queryphp-message-args {
    margin-left: 0px;
    padding: 5px 10px;
    width: 60%;
    border-radius: 3px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.125);
    background: rgba(238, 238, 238, 0.35);
    color: #999
}
</style>
</head>
<body>
    <div class="queryphp-message-container">
        <div class="queryphp-message-title"><?php echo isset( $mixError[ 'excetion_type' ] ) ? $mixError[ 'excetion_type' ] : 'Exception' ; ?></div>
        <div class="queryphp-message-subtitle">You can replace this with
            show_exception_template.</div>
        <div class="queryphp-message-content">
            <?php echo $mixError[ 'message' ]; ?>
        </div>
        
        <?php if( isset( $mixError [ 'file' ] ) ): ?>
        <div class="queryphp-message-detailtitle">Error Location:</div>
        <div class="queryphp-message-detailcontent">
            <ol>
                <li><a><span>#File</span> <?php echo $mixError['file']; ?></a></li>
                <li><a><span>#Line</span> <?php echo $mixError['line']; ?></a></li>
            </ol>
        </div>
        <?php endif;?>
        
        <?php if( isset( $mixError [ 'trace' ] ) ): ?>
        <div class="queryphp-message-detailtitle">Trace Message:</div>
        <div class="queryphp-message-detailcontent">
            <ol><?php echo $mixError [ 'trace' ]; ?></ol>
        </div>
        <?php endif;?>
    </div>
</body>

<script type="text/javascript"
    src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.js"></script>
<script type="text/javascript">
$(function(){
    $('[data-toggle]').on('click',function(){
        $('div.'+$(this).data('toggle')).toggle();
    });
});
</script>
</html>