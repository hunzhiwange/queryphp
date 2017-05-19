<?php
use Q\filesystem\directory;
$arrFile = [ 
        'pri/hello/AuthServiceProvider.php',
        'pri/hello/PaginationServiceProvider.php',
        'pri/world/HashServiceProvider.php',
        'pri/world/RedisServiceProvider.php',
        'pri/world/RoutingServiceProvider.php' 
];
function cache($arrFile, $strPath, $booForce = false) {
    if (is_file ( $strPath ) && $booForce === false) {
        return require $strPath;
    }
    
    $arrResult = [ ];
    $strContent;
    foreach ( $arrFile as $strFile ) {
        if (! is_array ( include_once $strFile ))
            continue;
        
        $strContent = str_replace ( PHP_EOL, ' ', trim ( php_strip_whitespace ( $strFile ) ) );
        $strContent = substr ( $strContent, strpos ( $strContent, '[' ) + 1, - (strlen ( $strContent ) - strripos ( $strContent, ']' )) );
        $strContent = trim ( rtrim ( trim ( $strContent ), ',' ) );
        $arrResult [] = $strContent;
    }
    
    if (! is_dir ( $strPath )) {
        directory::create ( is_dir ( $strPath ) );
    }
    
    file_put_contents ( $strPath, '<?php return [ ' . implode ( ', ', $arrContent ) . ' ];' );
    unset ( $strContent, $arrResult );
    
    return require $strPath;
}

//new Directory()


    
   // print_r($arrContent);

