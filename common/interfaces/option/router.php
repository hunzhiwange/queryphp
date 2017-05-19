<?php
use queryyetsimple\router\router;

router::imports ( 'topic-{id}-{orderby}', 'home://topic/show' );
router::imports ( [ 
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
router::imports ( 'new-{id}', 'home://new/index', [ 
        'where' => [ 
                'id',
                '[0-9]+' 
        ] 
] );

// 用法2
router::imports ( 'new-{id}-{name}', 'home://new/index', [ 
        'where' => [ 
                'id' => '[0-9]+',
                'name' => '[a-z]+' 
        ] 
] );

router::groups ( [ 
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

router::groups ( [ 
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

router::groups ( [ 
        'prefix' => 'myprefix-' 
], function () {
    router::imports ( 'new-{id}-{name}', 'home://new/index' );
    router::imports ( 'hello-{goods}', 'home://goods/index' );
} );

router::groups ( [ 
        'prefix' => 'myprefix-' 
], function () {
    router::groups ( [ 
            'params' => [ 
                    'args1' => '你',
                    'args2' => '好' 
            ] 
    ], function () {
        router::imports ( 'new-{id}-{name}', 'home://new/index' );
        router::imports ( 'hello-{goods}', 'home://goods/index' );
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