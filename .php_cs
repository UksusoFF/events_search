<?php

/*
 * TODO: Fix __construct new line difference with PHPStorm.
 * TODO: Fix short array syntax in ide helper model code.
 * TODO: Laravel model properties with array must be multiple line.
 */

$finder = PhpCsFixer\Finder::create()
    ->name('*.php')
    ->notName('*.blade.php')
    ->notName('_ide_helper.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database/migrations',
        __DIR__ . '/database/factories',
        __DIR__ . '/routes',
        __DIR__ . '/resources/lang',
    ]);

return PhpCsFixer\Config::create()
    ->setLineEnding("\n")
    ->setRules([
        '@PSR2' => true, //https://github.com/FriendsOfPHP/PHP-CS-Fixer/blob/master/src/RuleSet.php
        'function_declaration' => [
            'closure_function_spacing' => 'none', //PhpStorm Preferences: Spaces => Before Parentheses => Anonymous function parentheses
        ],
        /*
         * Part of @PSR2 but not work for multiline: https://github.com/FriendsOfPHP/PHP-CS-Fixer/issues/3637
        'braces' => [
            'position_after_functions_and_oop_constructs' => 'next',
        ],
        */
        'class_attributes_separation' => true,
        'psr4' => true,
        /* Strings */
        'simple_to_complex_string_variable' => true,
        'single_quote' => true,
        'explicit_string_variable' => true,
        /* Strings */
        /* Array */
        'array_syntax' => [
            'syntax' => 'short',
        ],
        'trailing_comma_in_multiline_array' => true,
        'no_trailing_comma_in_singleline_array' => true,
        /* Array */
        /* List */
        'list_syntax' => [
            'syntax' => 'short',
        ],
        /* List */
        /* Imports */
        'ordered_imports' => [
            'sortAlgorithm' => 'alpha',
        ],
        'no_unused_imports' => true,
        /* Imports */
        'single_blank_line_before_namespace' => true,
    ])
    ->setFinder($finder)
    ->setUsingCache(false);
