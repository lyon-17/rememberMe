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
         * @Route("/updRec/{id}/{status}", name="upd_recall")
         */
        public function updStateRecall(int $id, string $status): Response
        {
            $this->rememberManager->editRecallStatus($status,$id);
            return $this->redirectToRoute('index');
        }

}
