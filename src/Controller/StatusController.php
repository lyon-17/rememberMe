<?php

namespace App\Controller;

use App\Form\Type\StatusType;
use App\Form\Type\AddStatusType;
use App\Entity\Status;
use App\Repository\StatusRepository;
use App\Service\StatusHelper;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StatusController extends AbstractController 
{
    private $statusHelper;

    function __construct(StatusHelper $statusHelper)
    {
        $this->statusHelper = $statusHelper;
    }
     /**
     * @Route("/status/addState", name="add_state")
     */

    public function addState(ManagerRegistry $doctrine, Request $addRequest, StatusRepository $statusRepository)
    {
        $entityManager = $doctrine->getManager();
        $addState = new Status();
        $addForm = $this->createForm(AddStatusType::class,$addState);
        $addForm->handleRequest($addRequest);
        $status = $statusRepository->findAll();
        $icons = $this->statusHelper->generateIcons();
        
        if($addForm->get('add')->isClicked())
        {
            $addState->setName($addForm->get('name')->getData());
            $addState->setPriority($addForm->get('priority')->getData());
            $addState->setIcon($addForm->get('icon')->getData());
            $entityManager->persist($addState);
            $entityManager->flush();
            return $this->redirectToRoute('status');
        }
        return $this->renderForm('remember/status.html.twig',['addForm' => $addForm, 'status' => $status, 'icons' => $icons]);
    }

    /**
     * @Route("/status/setMain/{id}", name="main_state")
     */
    public function setStateMain(int $id)
    {
        $this->statusHelper->setStateMain($id);
        return $this->redirectToRoute('status');
    }

    /**
     * @Route("/status/edState/{id}", name="editState")
     */
    public function editState(ManagerRegistry $doctrine, Request $request, StatusRepository $statusRepository, StatusHelper $statusHelper, int $id)
    {
        $entityManager = $doctrine->getManager();

        $editState = $entityManager->getRepository(Status::class)->find($id);
        $status = $statusRepository->findAll();
        $editForm = $this->createForm(StatusType::class,$editState);
        $editForm->handleRequest($request);

        if($editForm->get('save')->isClicked())
        {
            $entityManager->flush();
            return $this->redirectToRoute('status');
        }

        if($editForm->get('exit')->isClicked())
        {
            return $this->redirectToRoute('status');
        }
        $icons = $statusHelper->generateIcons();
        
        return $this->renderForm('remember/status.html.twig',['editForm' => $editForm, 'editState' => $editState, 'status' => $status, 'icons' => $icons]);
    }
    /**
     * @Route("/status/delState/{id}", name="deleteState")
     */
    public function delState(StatusRepository $statusRepository, int $id)
    {
        $removed = $this->statusHelper->deleteState($id);
        $status = $statusRepository->findAll();

        if(!$removed)
        {
            return $this->renderForm('remember/status.html.twig',['status' => $status, 'log' => 'default values cant be removed']);
        }
        return $this->redirectToRoute('status');
    }

    /**
     * @Route("/status/active/{id}", name="active_state")
     */
    public function activeState(int $id)
    {
        $this->statusHelper->setStateActive($id, true);
        return $this->redirectToRoute('status');
    }

    /**
     * @Route("/status/deactive/{id}", name="desactivate_state")
     */
    public function desactivateState(int $id)
    {
        $this->statusHelper->setStateActive($id, false);
        return $this->redirectToRoute('status');
    }
}