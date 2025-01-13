<?php

use PhpCsFixer\Config;

return (new Config())
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude(['vendor', 'storage', 'bootstrap/cache'])
            ->in(__DIR__)
            ->name('*.php')
    );
