<?php

namespace Src\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Extensions extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('env', 'env')
        ];
    }
    public function env($key, $default = null)
    {
        return env($key, $default);
    }
}