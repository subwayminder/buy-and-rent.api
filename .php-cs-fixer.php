<?php

use PhpCsFixer\Finder;
use PhpCsFixer\Config;

$rules = [
    '@PSR12' => true,
    'no_trailing_whitespace_in_comment' => false,
    'single_trait_insert_per_statement' => false,
];

$finder = (new Finder())
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    ->name('*.php');

return (new Config())
    ->setRules($rules)
    ->setFinder($finder);
