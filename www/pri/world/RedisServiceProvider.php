<?php
return [ 
      
                'redis',
                function ($app) {
                    return new Database ( $app ['config'] ['database.redis'] );
                } 
     
];