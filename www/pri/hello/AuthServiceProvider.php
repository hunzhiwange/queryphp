<?php
return [ 
        
        [ 
                'auth',
                function ($app) {
                    // Once the authentication service has actually been requested by the developer
                    // we will set a variable in the application indicating such. This helps us
                    // know that we need to set any queued cookies in the after event later.
                    $app ['auth.loaded'] = true;
                    $app ['auth.loaded2'] = "我爱你的";
                    return new AuthManager ( $app );
                } 
        ],
        
        [ 
                'auth.driver',
                function ($app) {
                    return $app ['auth']->guard ();
                } 
        ],
        [ 
                'sssssssssssss',
                function ($app) {
                    return call_user_func ( $app ['auth']->userResolver () );
                } 
        ],
        [ 
                'yello',
                function ($app) {
                    return new Gate ( $app, function () use($app) {
                        return call_user_func ( $app ['auth']->userResolver () );
                    } );
                } 
        ]             ,                
  ]    


  

;
 

?>