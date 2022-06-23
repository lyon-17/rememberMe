<?php

namespace App\Controller;

use App\Entity\Recall;
use App\Service\RememberManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RecallController extends AbstractController
{

    private $rememberManager;

    function __construct(RememberManager $rememberManager)
    {
        $this->rememberManager = $rememberManager;
    }
        /**
         * @Route("/delRec/{id}", name="delete")
         */
        public function deleteRecall(int $id): Response
        {
            $this->rememberManager->deleteRecall($id);
            return $this->redirectToRoute('index');
        }

        /**
         * @Route("/updRec/{id}/urgent", name="urgent_recall")
         */
        public function urgRecall(int $id): Response
        {
            $this->rememberManager->editRecallStatus('urgent',$id);
            return $this->redirectToRoute('index');
        }

        /**
         * @Route("/updRec/{id}/done", name="done_recall")
         */
        public function doneRecall(int $id): Response
        {
            $this->rememberManager->editRecallStatus('done',$id);
            return $this->redirectToRoute('index');
        }

        /**
         * @Route("/updRec/{id}/progress", name="progress_recall")
         */
        public function progressRecall(int $id): Response
        {
            $this->rememberManager->editRecallStatus('progress',$id);
            return $this->redirectToRoute('index');
        }

}
