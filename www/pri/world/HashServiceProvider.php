<?php
return [ 
       
                'hash',
                function () {
                    return new BcryptHasher ();
                } 
    
];
