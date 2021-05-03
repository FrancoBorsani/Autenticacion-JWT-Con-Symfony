<?php

namespace App\Listeners;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AuthenticationSuccessListener
{

    /**
     * This function is responsible for the authentication part
     *
     * @param AuthenticationSuccessEvent $event
     * @return JWTAuthenticationSuccessResponse
     */
    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event)
    {
        $response = $event->getResponse();
        $data = $event->getData();
        $tokenJWT = $data['token'];
        unset($data['token']);
        unset($data['refresh_token']);

        //COOKIE SETEADA EN ENCABEZADO DE LA VARIABLE USER.
        $response->headers->setCookie(new Cookie('BEARER', $tokenJWT, (
            new \DateTime())
            ->add(new \DateInterval('PT' . 3600 . 'S')), '/', null, false));

        //COOKIE SETEADA EN EL NAVEGADOR WEB.
        setcookie('BEARER', $tokenJWT, ['samesite' => 'Lax']);



        return $response;
    }
}