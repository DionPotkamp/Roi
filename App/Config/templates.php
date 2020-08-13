<?php
return [
    'extension' => '.twig',
    'dir' => __DIR__.'/../Templates',
    'cache' => __DIR__.'/../../var/cache/templates',

    'twig_extensions' => [
        'Function' => 'Src\\Twig\\Extensions',
    ]
];
