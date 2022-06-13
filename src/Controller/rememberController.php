<?php

namespace App\Controller;

use App\Entity\Box;
use App\Entity\Recall;
use App\Form\Type\CreateType;
use App\Form\Type\EditType;
use App\Form\Type\BoxType;
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
    public function showIndex(ManagerRegistry $doctrine, Request $boxRequest, Request $editRequest, BoxRepository $boxRepository, RecallRepository $recallRepository): Response
    {
        $box = new Box();
        $recall = new Recall();
        $box->setBoxName('new box');
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(CreateType::class,$box);
        $form->handleRequest($boxRequest);
        $boxForm = $this->createForm(BoxType::class,$box);
        $log = '';
        
        if($form->get('new')->isClicked())
        {
            $entityManager->persist($box);
            $entityManager->flush();
            
        }

        if($form->get('recall')->isClicked())
        {
            $boxName = $form->get('boxName')->getData();
            $box = $boxRepository->findOneBy(['name' => $boxName]);
            $recall->setName('new recall');
            $recall->setTargetBox($box);
            $entityManager->persist($recall);
            $entityManager->flush();
            $log = 'new recall added in '.$boxName;
            //Editable the boxes and recall text in the same page if able. Also modify choice picker to allow the same name somehow
        }

        $editForm = $this->createForm(EditType::class,$box);
        $editForm->handleRequest($editRequest);

        if($editForm->get('save')->isClicked())
        {
            $entityManager->persist($box);
            $entityManager->flush();
        }
        
        $boxes = $boxRepository->findAll();
        $recalls = $recallRepository->findAll();

        return $this->renderForm('remember/index.html.twig',['form' => $form,'editForm' => $editForm, 'boxForm' => $boxForm, 'boxes' => $boxes, 'recalls' => $recalls, 'log' => $log]);
    }

}