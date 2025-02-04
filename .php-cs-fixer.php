<?php

use PhpCsFixer\Config;

return (new Config())
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
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
