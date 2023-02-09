<?php

declare(strict_types=1);

if (!function_exists('__')) {
    /**
     * lang.
     */
    function __(string $text, mixed ...$arr): string
    {
        // @phpstan-ignore-next-line
        return sprintf($text, ...$arr);
    }
}
