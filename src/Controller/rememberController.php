<?php

namespace App\Controller;

use App\Entity\Box;
use App\Form\Type\BoxType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class RememberController extends AbstractController 
{
    /**
     * @Route("/", name="index")
     */
    public function showIndex(ManagerRegistry $doctrine, Request $request): Response
    {
        $box = new Box();
        $box->setName('new box');
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(Boxtype::class,$box);
        $form->handleRequest($request);


        if($form->get('new')->isClicked())
        {
            //$entityManager->persist($box);
            //$entityManager->flush();
            return $this->renderForm('remember/index.html.twig',['form' => $form , 'log' => 'no new boxes for now']);
        }

        return $this->renderForm('remember/index.html.twig',['form' => $form]);
    }
}