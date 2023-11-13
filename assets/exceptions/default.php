<?php

declare(strict_types=1);

$title = $type ?? 'Whoops!';

if (!isset($messageDefault)) {
    $messageDefault = 'Unknown error.';
}

if (isset($file, $line)) {
    $title .= sprintf('<div class="file">#FILE %s #LINE %s</div>', $file, $line);
}

return require __DIR__.'/layout.php';
