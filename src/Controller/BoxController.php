<?php

namespace App\Controller;

use App\Entity\Box;
use App\Form\Type\EditType;
use App\Repository\StatusRepository;
use App\Service\RememberManager;
use App\Service\StatusHelper;
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
    public function updateBox(ManagerRegistry $doctrine, StatusRepository $statusRepository, StatusHelper $statusHelper, string $id, Request $editRequest): Response
    {
    
        if($id == "status")
        {
            return $this->redirectToRoute('status');
        }
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

        $status = $statusRepository->findAll();
        $icons = $statusHelper->generateIcons();
        
        return $this->renderForm('remember/index.html.twig',[
            'editForm' => $editForm,
            'editBox' => $editedBox,
            'boxes' => $items['boxes'],
            'recalls' => $items['recalls'],
            'status' => $status,
            'statusIcons' => $icons,
            'log' => $log]);
    }
}