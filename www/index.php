<?php
$oComposer = require dirname ( __DIR__ ) . '/vendor/autoload.php';
queryyetsimple\mvc\project::bootstrap ( $oComposer )->run ();
