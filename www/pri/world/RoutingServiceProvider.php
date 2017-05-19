<?php
return [ 
        
        [ 
                
                'router',
                function () {
                    $this->app->share ( function ($app) {
                        return new Router ( $app ['events'], $app );
                    } );
                } 
        ] 
];