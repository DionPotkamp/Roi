<?php

namespace Roi;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;

class ErrorHandler extends BaseController
{
    public function exception(FlattenException $exception)
    {
        $message = 'Something went wrong! ('.$exception->getMessage().')';

        return new Response($this->render($message), $exception->getStatusCode());
    }
}
