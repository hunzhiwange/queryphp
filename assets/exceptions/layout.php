<?php

declare(strict_types=1);

if (isset($shouldJson) && true === $shouldJson) {
    return require __DIR__.'/layout_json.php';
} else {
    return require __DIR__.'/layout_http.php';
}
