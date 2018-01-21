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