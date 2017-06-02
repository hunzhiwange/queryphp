<?php

namespace home\infrastructure\provider;

use Q\support\event_provider;

class event extends event_provider {
    protected $arrListener = [ 
            'home\domain\event\test_event' => [ 
                    'home\domain\listener\test_listener' 
            ] 
    ];
    
    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $arrSubscribe = [ 
            'home\domain\listener\use_listener' 
    ];
}
