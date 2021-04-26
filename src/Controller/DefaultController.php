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

use Symfony\Component\EventDispatcher\Event;


class DefaultController extends WebTestCase
{


    public function register2(Request $request, UserPasswordEncoderInterface $encoder)
    {
        //    $em = $this->getDoctrine()->getManager();

        //     $username = $request->request->get('_username');
        //     $password = $request->request->get('_password');

        //    $user = new User($username);
        //    $user->setPassword($encoder->encodePassword($user, $password));

        //    $em->persist($user);
        //    $em->flush();


        $user = static::createClient();
        $user->request(
            'POST',
            '/login_check',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            json_encode(array(
                'username' => $request->request->get('_username'),
                'password' => $request->request->get('_password'),
            ))
        );

        $data = json_decode($user->getResponse()->getContent(), true);
        // dump($data);
        $user->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        /*  $response = $user->getResponse();
            $jwt = $data['token'];
         //   dump($jwt);
            // Set cookie
            $response->headers->setCookie(
                new Cookie(
                    "BEARER",
                    $jwt,
                    new \DateTime("+1 day"),
                    "/",
                    null,
                    true,
                    true,
                    false,
                    'strict'
                )
            );*/

      
        $response = new Response();
        $response->headers->setCookie(
            new Cookie(
                'BEARER', // cookie name, should be the same as in JWT settings
                $data['token'], // the cookie value, e.g. the generated JWT token
                new \DateTime('+1 day'), // the expiration
                '/', // the path
                null, // the domain, null means that Symfony will generate it on its own
                true, // secure, e.g. only via https
                true, // http only cookie, which is the default so no need to specify
                false, // raw
                'strict' // the same-site parameter, can be 'lax' or 'strict'
            )
        );


        dump($response->headers);

        return new Response(sprintf('User %s successfully created', $request->request->get('_username')));
    }




    public function api()
    {
        return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));
    }
}
