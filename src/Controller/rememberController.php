<?php

namespace App\Controller;

use App\Entity\Box;
use App\Form\Type\BoxType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class RememberController extends AbstractController 
{
    /**
     * @Route("/", name="index")
     */
    public function showIndex(): Response
    {
        $box = new Box();
        $box->setName('new member');
        $form = $this->createForm(Boxtype::class,$box);
        return $this->renderForm('remember/index.html.twig',['form' => $form]);

    }
}