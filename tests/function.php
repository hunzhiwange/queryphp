<?php

declare(strict_types=1);

if (!function_exists('__')) {
    /**
     * lang.
     */
    function __(string $text, ...$arr): string
    {
        return sprintf($text, ...$arr);
    }
}
