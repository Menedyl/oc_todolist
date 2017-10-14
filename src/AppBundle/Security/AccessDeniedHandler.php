<?php

namespace AppBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;


/**
 * Created by PhpStorm.
 * User: Menedyl
 * Date: 13/10/2017
 * Time: 15:32
 */
class AccessDeniedHandler implements AccessDeniedHandlerInterface
{

    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {

        return new Response('Accès refusé !', 403);
    }

}
