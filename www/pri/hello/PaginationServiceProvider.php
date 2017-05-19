<?php
return [ 
  
        function () {
            Paginator::currentPathResolver ( function () {
                return $this->app ['request']->url ();
            } );
        },
        
        function () {
            Paginator::currentPageResolver ( function ($pageName = 'page') {
                $page = $this->app ['request']->input ( $pageName );
                
                if (filter_var ( $page, FILTER_VALIDATE_INT ) !== false && ( int ) $page >= 1) {
                    return $page;
                }
                
                return 1;
            } );
        } 
];
