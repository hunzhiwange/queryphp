<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
//
//var_dump(__DIR__.'/public'.$uri);
if ('/' !== $uri && file_exists(__DIR__.'/public'.$uri)) {
    require __DIR__.'/public'.$uri;

    return;
}

if ('/apis' === $uri) {
    header('Content-type: text/html; charset=utf-8');
    echo file_get_contents(__DIR__.$uri.'/index.html');

    return;
}
var_dump($uri);
require_once __DIR__.'/index.php';
