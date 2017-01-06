<?php
/*
 * [$QueryPHP] (C)QueryPHP.COM Since 2016.11.17.
 * 系统异常模版
 *
 * <The old is doyouhaobaby.com since 2010.10.04.>
 * @author dyhb<635750556@qq.com>
 * @version $$
 * @date 2016.11.19
 * @since 1.0
 */
! defined ( 'Q_PATH' ) && exit ();
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
    margin: 20px 0 40px 20px;
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
</style>
</head>
<body>
    <div class="queryphp-message-container">
        <div class="queryphp-message-title">Exception</div>
        <div class="queryphp-message-subtitle">
            You can replace this with show_exception_tpl.
        </div>
        <div class="queryphp-message-content">
            <?php echo $mixError[ 'message' ]; ?>
        </div>
        
        <?php if( isset( $mixError [ 'file' ] ) ): ?>
        <div class="bodytext">Error Location:</div>
        <div class="bodytext">
            <ul>
                <li>FILE: <?php echo $mixError['file'];?></li>
                <li>LINE:<?php echo $mixError['line'];?></li>
                </li>
            </ul>
        </div>
        <?php endif;?>
        
        <?php if( isset( $mixError [ 'trace' ] ) ) :?>
        <div class="bodytext">Trace Message:</div>
        <div class="bodytext">
            <ul><?php echo $mixError [ 'trace' ];?></ul>
        </div>
        <?php endif;?>
    </div>
</body>
</html>