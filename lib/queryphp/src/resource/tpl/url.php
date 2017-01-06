<?php
/*
 * [$QueryPHP] (C)QueryPHP.COM Since 2016.11.17.
 * url 跳转模版
 *
 * <The old is doyouhaobaby.com since 2010.10.04.>
 * @author dyhb<635750556@qq.com>
 * @version $$
 * @date 2017.01.02
 * @since 1.0
 */
! defined ( 'Q_PATH' ) && exit ();
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
    color: #dce2ec
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
        <div class="queryphp-message-title"><span id="sec"><?php echo $nTime;?></span>
            Seconds</div>
        <div class="queryphp-message-subtitle"><?php echo $sMsg;?></div>
    </div>
</body>
</html>