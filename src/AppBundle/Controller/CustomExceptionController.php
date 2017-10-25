<?php
/**
 * Created by PhpStorm.
 * User: Menedyl
 * Date: 18/10/2017
 * Time: 09:48
 */

namespace AppBundle\Controller;

use Symfony\Bundle\TwigBundle\Controller\ExceptionController;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

class CustomExceptionController extends ExceptionController
{
    public function showAction(Request $request, FlattenException $exception, DebugLoggerInterface $logger = null)
    {


        $code = $exception->getStatusCode();

        return new Response(
            $this->twig->render(
                (string)$this->findTemplate(
                    $request,
                    $request->getRequestFormat(),
                    $code,
                    false
                )
            ),
            $code);

    }

}
