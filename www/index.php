<?php
$oComposer = require dirname ( __DIR__ ) . '/vendor/autoload.php';
queryyetsimple\bootstrap\project::bootstrap ( $oComposer )->run ();
