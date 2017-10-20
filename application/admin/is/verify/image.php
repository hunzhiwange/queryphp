<?php

namespace admin\is\verify;

use queryyetsimple\cache;
use queryyetsimple\seccode\seccode;

class image {
    protected $oSeccode;
    public function __construct(seccode $oSeccode) {
        $this->oSeccode = $oSeccode;
    }
    public function run() {
        $this->oSeccode->options ( [ 
                'width' => 100,
                'height' => 30 
        ] )->display ( 4, true );
        
        cache::set ( 'admin_seccode', $this->oSeccode->getCode () );

        exit();
    }
    
}
