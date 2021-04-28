<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use PHPUnit\Framework\TestCase;
use DateTime;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Symfony\Component\HttpFoundation\Cookie;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\EventDispatcher\Event;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class LoginController extends WebTestCase
{
    public function createAuthenticatedClient($username, $password)
    {
        $user = static::createClient();
        $user->request(
            'POST',
            '/api/login_check',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            json_encode(array(
                 'username' => $username,
                 'password' => $password,
            ))
        );
        

        $data = json_decode($user->getResponse()->getContent(), true);

        //SI NO EXISTE LA COLUMNA "CODE" -> LA CUAL MUESTRA EL STATUS 401 (CREDENCIALES INVÁLIDAS) EN CASO DE FALLAR
        if(!array_key_exists('code', $data)){
            $user->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));
        }

        return $user;
   }

    
    public function login(Request $request, UserPasswordEncoderInterface $encoder)
    {

        $client = $this->createAuthenticatedClient($request->request->get('_username'), $request->request->get('_password'));
        $response = $client->request('GET', '/api');    //Si el usuario es válido.

        return new Response(sprintf('Completado'));
    }


}