<?php

declare(strict_types=1);

// https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/blob/v3.14.3/.php-cs-fixer.dist.php
return (new PhpCsFixer\Config())
    ->setRules([
        '@PHP74Migration' => true,
        '@PHP74Migration:risky' => true,
        '@PHPUnit100Migration:risky' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        '@PHP81Migration' => true,
        '@PHP80Migration:risky' => true,
        'heredoc_indentation' => true,
        'general_phpdoc_annotation_remove' => ['annotations' => ['expectedDeprecation']], // one should use PHPUnit built-in method instead
        'heredoc_indentation' => false, // TODO switch on when # of PR's is lower
        'modernize_strpos' => true, // needs PHP 8+ or polyfill
        'no_useless_concat_operator' => false, // TODO switch back on when the `src/Console/Application.php` no longer needs the concat
        'use_arrow_functions' => false, // TODO switch on when # of PR's is lower
        'php_unit_strict' => false,
    ])
    ->setRiskyAllowed(true)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__.'/app')
            ->in(__DIR__.'/api')
            ->append([__FILE__])
            ->in(__DIR__.'/tests')
            ->in(__DIR__.'/www')
            ->in(__DIR__.'/option')
            ->in(__DIR__.'/assets/database')
            ->exclude(__DIR__.'/vendor')
            ->exclude(__DIR__.'/storage')
    )
;
