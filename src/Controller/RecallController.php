<?php

namespace App\Controller;

use App\Entity\Recall;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RecallController extends AbstractController
{
        /**
         * @Route("/delRec/{id}", name="delete")
         */
        public function deleteRecall(ManagerRegistry $doctrine, int $id): Response
        {
            $entityManager = $doctrine->getManager();
            $deleteRecall = $entityManager->getRepository(Recall::class)->find($id);
            $entityManager->remove($deleteRecall);
            $entityManager->flush();
            return $this->redirectToRoute('index');
        }

        /**
         * @Route("/updRec/{id}/urgent", name="urgent_recall")
         */
        public function urgRecall(ManagerRegistry $doctrine, int $id): Response
        {
            $entityManager = $doctrine->getManager();
            $urgentRecall = $entityManager->getRepository(Recall::class)->find($id);
            $urgentRecall->setStatus('urgent');
            $entityManager->flush();
            return $this->redirectToRoute('index');
        }

        /**
         * @Route("/updRec/{id}/done", name="urgent_recall")
         */
        public function doneRecall(ManagerRegistry $doctrine, int $id): Response
        {
            $entityManager = $doctrine->getManager();
            $urgentRecall = $entityManager->getRepository(Recall::class)->find($id);
            $urgentRecall->setStatus('done');
            $entityManager->flush();
            return $this->redirectToRoute('index');
        }

}
