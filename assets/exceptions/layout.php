<?php

declare(strict_types=1);

if (!(isset($errorBlocking) && false === $errorBlocking)) {
    $message = $messageDefault ?? '';
}

if (isset($shouldJson) && true === $shouldJson) {
    return require __DIR__.'/layout_json.php';
}

return require __DIR__.'/layout_http.php';
