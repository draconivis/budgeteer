<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;
use Rector\Symfony\Set\SymfonySetList;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/config',
        __DIR__.'/public',
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
    // uncomment to reach your current PHP version
    ->withPhpSets(php83: true)
    ->withSets([
        SymfonySetList::SYMFONY_71,
        SetList::PHP_83,
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
    ])
    ->withRules([
        AddVoidReturnTypeWhereNoReturnRector::class,
    ])
;
