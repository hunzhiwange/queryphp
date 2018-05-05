<?php declare(strict_types=1);

namespace home\infrastructure\provider;

use queryyetsimple\bootstrap\provider\event as provider_event;

class event extends provider_event
{
    protected $arrListener = [
        'common\domain\event\test' => [
            'common\domain\listener\test'
        ],

        'common\domain\event\test2' => [
            'common\domain\listener\test2'
        ]
    ];
}
