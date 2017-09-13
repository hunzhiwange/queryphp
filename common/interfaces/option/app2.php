<?php
/**
 * 默认配置文件
 */
return [ 
        //'default_response'=>'api',
        '+option_extend' => [ 
                'helloword22',
                'yess22',
                'cookie' 
        ],
        'provider_with_cache' => [ 
 
        ],

        'provider' => ['home\infrastructure\provider\event']
        
];
