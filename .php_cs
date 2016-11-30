<?php

$header = <<<EOF
This file is part of the GeckoPackages.

(c) GeckoPackages https://github.com/GeckoPackages

This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.
EOF;

Symfony\CS\Fixer\Contrib\HeaderCommentFixer::setHeader($header);

return Symfony\CS\Config\Config::create()
    // use SYMFONY_LEVEL:
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    // and extra fixers:
    ->fixers(array(
        'combine_consecutive_unsets',
        'ereg_to_preg',
        'header_comment',
        'long_array_syntax',
        'newline_after_open_tag',
        'no_useless_else',
        'no_useless_return',
        'ordered_use',
        'php_unit_construct',
        'php_unit_dedicate_assert',
        'php_unit_strict',
        'phpdoc_order',
        'strict',
        'strict_param',
        '-empty_return',
        '-php_unit_fqcn_annotation',
        '-phpdoc_short_description',
        '-phpdoc_to_comment',
        '-psr0',
    ))
    ->finder(
        Symfony\CS\Finder\DefaultFinder::create()
            ->in(__DIR__.'/src/')
            ->in(__DIR__.'/tests/')
            ->name('*.php')
    )
;
