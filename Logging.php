<?php

$wgMWLoggerDefaultSpi = [
    'class' => '\\MediaWiki\\Logger\\MonologSpi',
    'args' => [ [
        'loggers' => [
            '@default' => [
                'processors' => [ 'wiki', 'psr' ],
                'handlers' => [ 'stream' ]
            ],
        ],
        'processors' => [
            'wiki' => [ 'class' => '\\MediaWiki\\Logger\\Monolog\\WikiProcessor' ],
            'psr' => [ 'class' => '\\Monolog\\Processor\\PsrLogMessageProcessor' ],
        ],
        'handlers' => [
            'stream' => [
                'class' => '\\Monolog\\Handler\\StreamHandler',
                'args' => [ __DIR__ . "/../logs/$wgDBname/debugging.log" ],
                'formatter' => 'line'
            ],
        ],
        'formatters' => [
            'line' => [ 'class' => '\\Monolog\\Formatter\\LineFormatter' ],
        ]
    ] ]
];
