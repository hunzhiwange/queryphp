<?php

declare(strict_types=1);

$title = isset($type) ? $type : 'Whoops!';

if (!isset($message)) {
    $message = 'Unknown error.';
}

if (isset($file, $line)) {
    $title .= sprintf('<div class="file">#FILE %s #LINE %s</div>', $file, $line);
}

require __DIR__.'/layout.php';
