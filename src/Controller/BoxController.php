<?php

namespace App\Controller;

use App\Entity\Box;
use App\Form\Type\EditType;
use App\Service\RememberManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\Persistence\ManagerRegistry;

class BoxController extends AbstractController
{
    private RememberManager $rememberManager;

    function __construct(RememberManager $rememberManager)
    {
        $this->rememberManager = $rememberManager;
    }
    /**
    * @Route("/delBox/{id}", name="remove_box")
    */
        public function deleteBox(int $id): Response
        {
            $this->rememberManager->removeBox($id);
            return $this->redirectToRoute('index');
        }
    /**
    * @Route("/updBox/{id}", name="update_box")
    */
    public function updateBox(ManagerRegistry $doctrine, int $id, Request $editRequest): Response
    {

        $entityManager = $doctrine->getManager();
        $log = '';

        $items = $this->rememberManager->getItems();

        $editedBox = $entityManager->getRepository(Box::class)->find($id);
        $editForm = $this->createForm(EditType::class,$editedBox);
        $editForm->handleRequest($editRequest);

        if($editForm->get('save')->isClicked())
        {
            $entityManager->flush();
            return $this->redirectToRoute('index');
        }

        if($editForm->get('exit')->isClicked())
        {
            return $this->redirectToRoute('index');
        }
        
        return $this->renderForm('remember/index.html.twig',['editForm' => $editForm, 'editBox' => $editedBox, 'boxes' => $items['boxes'], 'recalls' => $items['recalls'], 'log' => $log]);
    }
}