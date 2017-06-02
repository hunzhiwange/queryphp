<?php
use queryyetsimple\router\router;

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

/**
 * 路由配置文件
 */
return [ 
        [ 
                'url2-{args}',
                'home2://info/other' 
        ],
        [ 
                'url-{page}-{args}',
                'home://thank/you' 
        ] 
];