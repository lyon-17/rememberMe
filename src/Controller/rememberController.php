<?php

namespace App\Controller;

use App\Entity\Box;
use App\Entity\Recall;
use App\Form\Type\BoxType;
use App\Form\Type\RecallType;
use App\Repository\BoxRepository;
use App\Repository\RecallRepository;
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
    public function showIndex(ManagerRegistry $doctrine, Request $request, BoxRepository $boxRepository, RecallRepository $recallRepository): Response
    {
        $box = new Box();
        $recall = new Recall();
        $box->setName('new box');
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(Boxtype::class,$box);

        $recallForm = $this->createForm(RecallType::class,$recall);
        $recallForm->handleRequest($request);
        $boxes = $boxRepository->getBoxes();

        if($form->get('new')->isClicked())
        {
            //$entityManager->persist($box);
            //$entityManager->flush();
            return $this->renderForm('remember/index.html.twig',['form' => $form ,'recallForm' => $recallForm, 'log' => 'no new boxes for now']);
        }
        //Need to 
        if($recallForm->get('recall')->isClicked())
        {
            $boxName = $recallForm->get('boxName')->getData();
            $box = $boxRepository->findOneBy(['name' => $boxName]);
            $recall->setName('new recall');
            $recall->setTargetBox($box);
            //$entityManager->persist($recall);
            //$entityManager->flush();
            return $this->renderForm('remember/index.html.twig',['form' => $form ,'recallForm' => $recallForm,'boxes' => $boxes, 'log' => 'you did great']);
        }

        return $this->renderForm('remember/index.html.twig',['form' => $form,'recallForm' => $recallForm,'boxes' => $boxes]);
    }
}