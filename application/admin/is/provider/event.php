<?php

namespace home\infrastructure\provider;

use queryyetsimple\bootstrap\provider\event as provider_event;

class event extends provider_event
{
    protected $arrListener = [
            'home\domain\event\test' => [
                    'home\domain\listener\test'
            ],

            'home\domain\event\test2' => [
                    'home\domain\listener\test2'
            ]
    ];
}
