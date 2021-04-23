<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="receta_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }


   
}
