<?php

declare(strict_types=1);

// https://github.com/FriendsOfPHP/PHP-CS-Fixer/blob/2.12/.php_cs.dist
return (new PhpCsFixer\Config())
    ->setRules([
        // 'logical_operators' => true,
        // 'method_argument_space' => ['on_multiline' => 'ensure_fully_multiline'],
        // 'no_binary_string' => true,
        // 'php_unit_internal_class' => true,
        // 'no_unset_on_property' => true,
        // 'php_unit_test_case_static_method_calls' => ['call_type' => 'this'],
        // 'phpdoc_trim_consecutive_blank_line_separation' => true,
        // 'return_assignment' => true,
        // '@PHP56Migration'                               => true,
        // '@PHPUnit60Migration:risky'                     => true,
        // '@Symfony'                                      => true,
        // '@Symfony:risky'                                => true,
        // 'align_multiline_comment'                       => true,
        // 'array_indentation'                             => true,
        // 'array_syntax'                                  => ['syntax' => 'short'],
        // 'blank_line_before_statement'                   => true,
        // 'combine_consecutive_issets'                    => true,
        // 'combine_consecutive_unsets'                    => true,
        // 'comment_to_phpdoc'                             => true,
        // 'compact_nullable_typehint'                     => true,
        // 'escape_implicit_backslashes'                   => true,
        // 'explicit_indirect_variable'                    => true,
        // 'explicit_string_variable'                      => true,
        // 'final_internal_class'                          => true,
        // 'fully_qualified_strict_types'                  => true,
        // 'function_to_constant'                          => ['functions' => ['get_class', 'get_called_class', 'php_sapi_name', 'phpversion', 'pi']],
        // 'heredoc_to_nowdoc'                             => true,
        // 'list_syntax'                                   => ['syntax' => 'long'],
        // 'method_chaining_indentation'                   => true,
        // 'multiline_comment_opening_closing'             => true,
        // 'no_alternative_syntax'                         => true,
        // 'no_extra_blank_lines'                          => ['tokens' => ['break', 'continue', 'extra', 'return', 'throw', 'use', 'parenthesis_brace_block', 'square_brace_block', 'curly_brace_block']],
        // 'no_null_property_initialization'               => true,
        // 'no_short_echo_tag'                             => true,
        // 'no_superfluous_elseif'                         => true,
        // 'no_unneeded_curly_braces'                      => true,
        // 'no_unneeded_final_method'                      => true,
        // 'no_unreachable_default_argument_value'         => true,
        // 'no_useless_else'                               => true,
        // 'no_useless_return'                             => true,
        // 'ordered_class_elements'                        => true,
        // 'ordered_imports'                               => true,
        // 'php_unit_ordered_covers'                       => true,
        // 'php_unit_set_up_tear_down_visibility'          => true,
        // 'php_unit_strict'                               => false,
        // 'php_unit_test_annotation'                      => true,
        // 'php_unit_test_class_requires_covers'           => false,
        // 'phpdoc_add_missing_param_annotation'           => true,
        // 'phpdoc_order'                                  => true,
        // 'phpdoc_types_order'                            => true,
        // 'semicolon_after_instruction'                   => true,
        // 'single_line_comment_style'                     => true,
        // 'strict_comparison'                             => true,
        // 'strict_param'                                  => true,
        // 'string_line_ending'                            => true,
        // 'yoda_style'                                    => true,
        // 'binary_operator_spaces'                        => ['align_double_arrow' => true], // 自动对齐数组
        // 'increment_style'                               => ['style' => 'post'], // 自增自减操作符位置
        // 'native_function_invocation'                    => false, // 在函数调用之前添加前导 “\” 以加速解析。
        // 'heredoc_indentation'                           => true, // Heredoc / nowdoc 内容必须正确缩进。
        // 'phpdoc_trim_consecutive_blank_line_separation' => true,
        // 'no_superfluous_phpdoc_tags'                    => ['allow_mixed' => true],
        '@PHP74Migration' => true,
        '@PHP74Migration:risky' => true,
        '@PHPUnit100Migration:risky' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        '@PHP81Migration' => true,
        '@PHP80Migration:risky' => true,
        'heredoc_indentation' => false,
        'general_phpdoc_annotation_remove' => ['annotations' => ['expectedDeprecation']], // one should use PHPUnit built-in method instead
        // 'header_comment' => ['header' => $header],
        'heredoc_indentation' => false, // TODO switch on when # of PR's is lower
        'modernize_strpos' => true, // needs PHP 8+ or polyfill
        'no_useless_concat_operator' => false, // TODO switch back on when the `src/Console/Application.php` no longer needs the concat
        'use_arrow_functions' => false, // TODO switch on when # of PR's is lower
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
            ->exclude(__DIR__.'/runtime')
    )
;
