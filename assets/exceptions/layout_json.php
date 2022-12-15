<?php

declare(strict_types=1);

return [
    'error' => [
        'title' => $title,
        'status_code' => $status_code ?? 500,
        'code' => $code,
        'message' => $message,
    ],
];
