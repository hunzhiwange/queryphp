<?php
use queryyetsimple\router;

router::import ( 'hello-{what}', 'home://index/yes' );
router::import ( 'post/{id}', 'home://index/show' );

router::method( '*://index/ind',['post','get'] );
//router::method( 'home://index/index','get' );
router::middleware('home://index/index','queryyetsimple\throttler\middleware\throttler:15,15');//