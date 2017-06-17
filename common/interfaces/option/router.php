<?php
use queryyetsimple\router;

router::import ( 'topic-{id}-{orderby}', 'home://topic/show' );
router::import ( [ 
        [ 
                'new',
                'home://new/index' 
        ],
        [ 
                'topic-{id}',
                'group://topic/view' 
        ] 
] );

// 用法1
router::import ( 'new-{id}', 'home://new/index', [ 
        'where' => [ 
                'id',
                '[0-9]+' 
        ] 
] );

// 用法2
router::import ( 'new-{id}-{name}', 'home://new/index', [ 
        'where' => [ 
                'id' => '[0-9]+',
                'name' => '[a-z]+' 
        ] 
] );

router::group ( [ 
        'domain' => '{domain}.queryphp.com' 
], [ 
        [ 
                'new-{id}-{name}',
                'home://new/index' 
        ],
        [ 
                'hello-{goods}',
                'home://goods/index' 
        ] 
] );

router::group ( [ 
        'prepend' => true 
], [ 
        [ 
                'new-{id}-{name}',
                'home://new/index' 
        ],
        [ 
                'hello-{goods}',
                'home://goods/index' 
        ] 
] );

router::group ( [ 
        'prefix' => 'myprefix-' 
], function () {
    router::import ( 'new-{id}-{name}', 'home://new/index' );
    router::import ( 'hello-{goods}', 'home://goods/index' );
} );

router::group ( [ 
        'prefix' => 'myprefix-' 
], function () {
    router::group ( [ 
            'params' => [ 
                    'args1' => '你',
                    'args2' => '好' 
            ] 
    ], function () {
        router::import ( 'new-{id}-{name}', 'home://new/index' );
        router::import ( 'hello-{goods}', 'home://goods/index' );
    } );
} );

/**
 * 路由配置文件
 */
return [ 
        [ 
                'url-{args}',
                'home://info/other' 
        ],
        [ 
                'url-{page}-{args}',
                'home://thank/you' 
        ] 
];