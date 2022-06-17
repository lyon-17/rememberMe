<?php

namespace App\Controller;

use App\Entity\Recall;
use App\Service\FormManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RecallController extends AbstractController
{

    private $formManager;

    function __construct(FormManager $formManager)
    {
        $this->formManager = $formManager;
    }
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
        public function urgRecall(int $id): Response
        {
            $this->formManager->editRecallStatus('urgent',$id);
            return $this->redirectToRoute('index');
        }

        /**
         * @Route("/updRec/{id}/done", name="done_recall")
         */
        public function doneRecall(int $id): Response
        {
            $this->formManager->editRecallStatus('done',$id);
            return $this->redirectToRoute('index');
        }

        /**
         * @Route("/updRec/{id}/progress", name="progress_recall")
         */
        public function progressRecall(int $id): Response
        {
            $this->formManager->editRecallStatus('progress',$id);
            return $this->redirectToRoute('index');
        }

}
