<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class rememberController extends AbstractController 
{
    /**
     * @Route("/", name="index")
     */
    public function showIndex(): Response
    {
        return $this->render('remember/index.html.twig');
    }
}