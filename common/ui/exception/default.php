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

$title = isset($type) ? $type : 'Whoops!';

if (!isset($message)) {
    $message = 'Unknown error.';
}

if (isset($file, $line)) {
    $title .= sprintf('<div class="file">#FILE %s #LINE %s</div>', $file, $line);
}

require __DIR__.'/layout.php';
