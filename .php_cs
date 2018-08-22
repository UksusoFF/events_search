<?php

/*
 * TODO: Fix __construct new line difference with PHPStorm.
 * TODO: Fix short array syntax in ide helper model code.
 * TODO: Laravel model properties with array must be multiple line.
 */

$finder = PhpCsFixer\Finder::create()
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database/migrations',
        __DIR__ . '/routes',
        __DIR__ . '/resources/lang',
    ]);

return PhpCsFixer\Config::create()
    ->setLineEnding("\n")
    ->setRules([
        'braces' => [
            'position_after_functions_and_oop_constructs' => 'next',
        ],
        'concat_space' => [
            'spacing' => 'one',
        ],
        'elseif' => true,
        'no_extra_consecutive_blank_lines' => true,
        'full_opening_tag' => true,
        'encoding' => true,
        //'ordered_class_elements' => true,
        'function_declaration' => true,
        'include' => true,
        'lowercase_constants' => false,
        'lowercase_keywords' => true,
        'method_argument_space' => true,
        'trailing_comma_in_multiline_array' => true,
        'no_leading_namespace_whitespace' => true,
        'no_blank_lines_after_class_opening' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_trailing_comma_in_singleline_array' => true,
        'no_spaces_around_offset' => true,
        'no_unused_imports' => true,
        'phpdoc_indent' => true,
        'phpdoc_inline_tag' => true,
        'phpdoc_no_access' => true,
        'phpdoc_no_package' => true,
        'phpdoc_scalar' => true,
        'phpdoc_to_comment' => true,
        'phpdoc_trim' => true,
        'phpdoc_var_without_name' => true,
        'self_accessor' => true,
        'array_syntax' => [
            'syntax' => 'short',
        ],
        'list_syntax' => [
            'syntax' => 'long',
        ],
        'single_blank_line_before_namespace' => true,
        'blank_line_after_namespace' => true,
        'single_line_after_imports' => true,
        'single_quote' => true,
        'standardize_not_equals' => true,
        'ternary_operator_spaces' => true,
        'no_trailing_whitespace' => true,
        'no_trailing_whitespace_in_comment' => true,
        'no_whitespace_in_blank_line' => true,
        'trim_array_spaces' => true,
        'method_separation' => true,
        'ordered_imports' => [
            'sortAlgorithm' => 'alpha',
        ],
        'new_with_braces' => true,
        'phpdoc_types' => true,
    ])
    ->setFinder($finder)
    ->setUsingCache(false);