<?php
// (c) 2018 http://your.domain.com All rights reserved.

/**
 * 系统调试模版
 *
 * @author Xiangmin Liu <635750556@qq.com>
 * @package $$
 * @since 2016.12.18
 * @version 1.0
 */
?>
<script type="text/javascript">
console.log( '%cThe PHP Framework For Code Poem As Free As Wind %c(http://www.queryphp.com)', 'font-weight: bold;color: #06359a;', 'color: #02d629;' );
<?php foreach ($trace as $key => $item): ?>
    <?php if (is_string($key)): ?>
        console.log('');
        console.log('%c <?php echo $key; ?>', 'color: blue; background: #045efc; color: #fff; padding: 8px 15px; -moz-border-radius: 15px; -webkit-border-radius: 15px; border-radius: 15px;');
        console.log('');
    <?php endif; ?>
    <?php if ($item): ?>
        console.log('%c<?php echo $item; ?>', 'color: gray;');
    <?php endif; ?>
<?php endforeach; ?>
</script>