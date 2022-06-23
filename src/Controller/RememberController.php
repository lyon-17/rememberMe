<?php

namespace App\Controller;

use App\Entity\Box;
use App\Form\Type\CreateType;
use App\Repository\StatusRepository;
use App\Service\RememberManager;
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
    public function showIndex(ManagerRegistry $doctrine, Request $boxRequest, RememberManager $rememberManager): Response
    {
        $box = new Box();
        $box->setName('New box');
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(CreateType::class,$box);
        $form->handleRequest($boxRequest);
        $log = '';
        
        if($form->get('new')->isClicked())
        {
            $entityManager->persist($box);
            $entityManager->flush();
        }

        if($form->get('recall')->isClicked())
        {
            $boxName = $form->get('boxName')->getData();
            $log = $rememberManager->addRecall($boxName);
        }
        $items = $rememberManager->getItems();

        return $this->renderForm('remember/index.html.twig',['form' => $form, 'boxes' => $items['boxes'], 'recalls' => $items['recalls'], 'log' => $log]);
    }

    /**
     * @Route("/status", name="status")
     */
    public function showStatus(StatusRepository $statusRepository): Response
    {
        $status = $statusRepository->findAll();
        return $this->renderForm('remember/status.html.twig',['status' => $status]);
    }

}