<?php

namespace App\Controller;

use App\Form\Type\StatusType;
use App\Form\Type\AddStatusType;
use App\Entity\Status;
use App\Repository\StatusRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StatusController extends AbstractController 
{
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
        
        if($addForm->get('add')->isClicked())
        {
            $addState->setName($addForm->get('name')->getData());
            $addState->setPriority($addForm->get('priority')->getData());
            $addState->setIcon($addForm->get('icon')->getData());
            $entityManager->persist($addState);
            $entityManager->flush();
            return $this->redirectToRoute('status');
        }
        return $this->renderForm('remember/status.html.twig',['addForm' => $addForm, 'status' => $status]);
    }

    /**
     * @Route("/status/setMain/{id}", name="main_state")
     */
    public function setStateMain(ManagerRegistry $doctrine, StatusRepository $statusRepository, int $id)
    {
        $entityManager = $doctrine->getManager();
        $mainState = $statusRepository->find($id);
        $removeState = $statusRepository->getMain();
        $removeState->setMain(false);
        $mainState->setMain(true);
        $entityManager->flush();
        return $this->redirectToRoute('status');
    }

    /**
     * @Route("/status/edState/{id}", name="editState")
     */
    public function editState(ManagerRegistry $doctrine, Request $request, StatusRepository $statusRepository, int $id)
    {
        $entityManager = $doctrine->getManager();
        $log = '';

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
        
        return $this->renderForm('remember/status.html.twig',['editForm' => $editForm, 'editState' => $editState, 'status' => $status, 'log' => $log]);
    }
    /**
     * @Route("/status/delState/{id}", name="deleteState")
     */
    public function delState(ManagerRegistry $doctrine, StatusRepository $statusRepository, int $id)
    {
        $entityManager = $doctrine->getManager();
        $log = '';

        $removeState = $entityManager->getRepository(Status::class)->find($id);

        $status = $statusRepository->findAll();
        //Default values cant be deleted
        if($removeState->getId() > 3 && !$removeState->isMain())
        {
            $entityManager->remove($removeState);
            $entityManager->flush();
        }
        else{
            $log = 'Default values cannot be removed';
            return $this->renderForm('remember/status.html.twig',['status' => $status, 'log' => $log]);
        }
        return $this->redirectToRoute('status');
    }

    /**
     * @Route("/status/active/{id}", name="active_state")
     */
    public function activeState(ManagerRegistry $doctrine, int $id)
    {
        $entityManager = $doctrine->getManager();
        $inactiveState = $entityManager->getRepository(Status::class)->find($id);
        $inactiveState->setActive(true);
        $entityManager->flush();
        return $this->redirectToRoute('status');
    }

    /**
     * @Route("/status/deactive/{id}", name="desactivate_state")
     */
    public function desactivateState(ManagerRegistry $doctrine, int $id)
    {
        $entityManager = $doctrine->getManager();
        $inactiveState = $entityManager->getRepository(Status::class)->find($id);
        $inactiveState->setActive(false);
        $entityManager->flush();
        return $this->redirectToRoute('status');
    }
}