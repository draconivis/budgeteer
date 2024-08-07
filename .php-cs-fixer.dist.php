<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = (new Finder())
    ->in(__DIR__)
    ->exclude('var')
;

return (new Config())
    ->setRules([
        '@Symfony' => true,
        '@DoctrineAnnotation' => true,
        '@PSR1' => true,
        '@PSR12' => true,
        '@PhpCsFixer' => true,
    ])
    ->setFinder($finder)
;
