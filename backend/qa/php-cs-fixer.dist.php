<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/../src/')
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
    ->exclude('vendor');

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        'psr_autoloading' => true, // PSR4
        '@PSR12' => true,
    ])
    ->setFinder($finder);
