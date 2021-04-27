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
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;


class LoginController extends WebTestCase
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
        dump($user);
        dump($user->getResponse());
       // $user->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));
       $user->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MTk1NDkzOTUsImV4cCI6MTYxOTU1Mjk5NSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoiam9obmRvZSJ9.ugQX3FrhPUeKOQ1Z2TbdqOKX5e9_ssUJfCkq6qsKZw-X1RB1UN02gseXtVcdC9TuZrKGE9YZEtz16BaoacGjD1glsJcR_4ZASXOP4w-K7Le77eNh3cS5bt5Ev7Rowwr--2Eoa2ynqbw22-emyGR1GDCoIoqpAG8chKBv1qUlclVmTl1PmP-1stJK20LBclrB0EXRO-GVgOQRLiTDePlhDi8aEykFGZCSYs6D_vEO5GsrN-b6lsC7s8OFjVKW_2S4IeAKhpHxT5woh1K_W0wDBJ3glPnSgw0KPBwTMohey_geiuZzbzDkWy6JqvU5B4fU2ghUuCxras4Vb2QUxY_AfATcXGY2y1et3bFuBSM7sDchOd-xcd9NA9pD4qBXA2THy1VWt82PPBMPIv3Xha971KgG3KssHwcUtpi0_0yk6CjeWaNSg5pT4-OHJv_PzBZoEdGWAcrfr0rcEvn61iAF4eaj7Mb8GeL-q2JIlAzzZZJcB5OkAQ_QA_MbiI4zXxxczJe61Y28UNqwvqm1CQIeXJAeaz6T7Ggm_oQrcKIKBPNAnQlweXnPjUA1NnFgd3Fas2rK0JakX1eQT-Yp7vCxQ7M0AAL0WqzxjowjTUgp8jHHdNC-oXCeQv8Q7zU1g0rg3h0D-WcppctG1MZWakr-Pzqvr-n_Ln2nOt3w4bbOYmc"));

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



       // setcookie("galleta", $data['token'], time()+3000, "/", "localhost:8000", true, true);

     //   dump($response->headers);



        return new Response(sprintf('User %s successfully created', $request->request->get('_username')));
    }




    public function api()
    {
        return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));
    }
}