<?php

$headerComment = <<<COMMENT
This file is part of the Wucdbm Symfony SSE Response package.

Copyright (c) Martin Kirilov <wucdbm@gmail.com>

Author Martin Kirilov <wucdbm@gmail.com>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
COMMENT;

$finder = PhpCsFixer\Finder::create()->in(__DIR__ . '/src');

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony'                                     => true,
        'no_blank_lines_after_class_opening'           => false,
        'array_syntax'                                 => [
            'syntax' => 'short'
        ],
        'braces'                                       => [
            'position_after_functions_and_oop_constructs' => 'same'
        ],
        'header_comment'                               => [
            'header' => $headerComment
        ]
    ])
    ->setUsingCache(false)
    ->setFinder($finder);
