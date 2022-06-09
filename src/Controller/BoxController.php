<?php

namespace App\Controller;

use App\Entity\Box;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
            $entityManager->remove($deleteBox);
            $entityManager->flush();
            return $this->redirectToRoute('index');
        }
}