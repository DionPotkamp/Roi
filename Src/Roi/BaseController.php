<?php


namespace Roi;

use Twig\Environment;

class BaseController
{
    private $twigEnv;

    public function __construct(Environment $twigEnv)
    {
        $this->twigEnv = $twigEnv;
    }

    public function render($array) {
        return $this->twigEnv->render($array);
    }

}