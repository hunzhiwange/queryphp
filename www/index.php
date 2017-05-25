<?php
/**
 * 执行项目
 */
$objComposer = require dirname ( __DIR__ ). '/vendor/autoload.php';
queryyetsimple\mvc\project::bootstrap ( $objComposer )->run ();
