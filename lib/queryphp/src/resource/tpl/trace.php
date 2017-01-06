<?php
/*
 * [$QueryPHP] (C)QueryPHP.COM Since 2016.11.17.
 * 系统调试模版
 *
 * <The old is doyouhaobaby.com since 2010.10.04.>
 * @author dyhb<635750556@qq.com>
 * @version $$
 * @date 2016.12.18
 * @since 1.0
 */
! defined ( 'Q_PATH' ) && exit ();
?>
<script type="text/javascript">
console.log( '%c Query Yet Simple [trace] %c(http://www.queryphp.com)', 'color: #8A2BE2;', 'color: #528B8B;' );
<?php foreach ( $arrTrace as $sKey => $sTrace ) : ?>
    <?php if( is_string($sKey) ) : ?>
        console.log('');
        console.log('%c <?php echo $sKey; ?>', 'color: blue; background: #C9C9C9; color: #fff; padding: 8px 15px; -moz-border-radius: 15px; -webkit-border-radius: 15px; border-radius: 15px;');
        console.log('');
    <?php endif; ?>
    <?php if( $sTrace ) : ?>
        console.log('%c<?php echo $sTrace; ?>', 'color: gray;');
    <?php endif; ?>
<?php endforeach; ?>
</script>