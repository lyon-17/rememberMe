<?php

namespace App\Controller;

use App\Entity\Box;
use App\Entity\Recall;
use App\Form\Type\EditType;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\Persistence\ManagerRegistry;

class BoxController extends AbstractController
{
    /**
    * @Route("/delBox/{id}", name="remove_box")
    */
        public function deleteBox(ManagerRegistry $doctrine, int $id): Response
        {
            $entityManager = $doctrine->getManager();
            $deleteBox = $entityManager->getRepository(Box::class)->find($id);
            $deleteRecalls = $entityManager->getRepository(Recall::class)->findBy(['target_box' => $id]);
            foreach ($deleteRecalls as $key => $value) {
                $entityManager->remove($value);
            }
            $entityManager->remove($deleteBox);
            $entityManager->flush();
            return $this->redirectToRoute('index');
        }
    /**
    * @Route("/updBox/{id}", name="update_box")
    */
    public function updateBox(ManagerRegistry $doctrine, int $id, Request $editRequest): Response
    {
        $entityManager = $doctrine->getManager();
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

        return $this->renderForm('remember/edit.html.twig',['editForm' => $editForm, 'box' => $editedBox]);
    }
}