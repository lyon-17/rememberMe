<?php

namespace App\Controller;

use App\Entity\Recall;

use Symfony\Component\HttpFoundation\Request;
use App\Form\Type\EditDescriptionType;
use App\Repository\StatusRepository;
use App\Service\RememberManager;
use App\Service\StatusHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
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

        /**
         * @Route("updDesc/{id}", name="upd_desc")
         */
        public function updateDescRecall(RememberManager $rememberManager,StatusRepository $statusRepository, StatusHelper $statusHelper, ManagerRegistry $doctrine, Request $descRequest, string $id)
        {
            if( $id == "status")
            {
                return $this->redirectToRoute('status');
            }
            $entityManager = $doctrine->getManager();
            $items = $rememberManager->getItems();
            $status = $statusRepository->findBy(['active' => true]);
            $recDesc = $entityManager->getRepository(Recall::class)->find($id);
            $icons = $statusHelper->generateIcons();
            $editDesc = $this->createForm(EditDescriptionType::class,$recDesc);
            $editDesc->handleRequest($descRequest);

            if($editDesc->get('save')->isClicked())
            {
            $entityManager->flush();
            return $this->redirectToRoute("index");
            }

            return $this->renderForm('remember/index.html.twig',[
            'editDesc' => $editDesc,
            'recDesc' => $recDesc,
            'boxes' => $items['boxes'],
            'recalls' => $items['recalls'],
            'status' => $status,
            'statusIcons' => $icons
            ]);
        }

}
