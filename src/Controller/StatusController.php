<?php

namespace App\Controller;

use App\Form\Type\StatusType;
use App\Entity\Status;
use App\Repository\StatusRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StatusController extends AbstractController 
{

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
        //Default values cant be deleted
        if($removeState->getId() > 3 && !$removeState->isMain())
        {
            $entityManager->remove($removeState);
            $entityManager->flush();
        }
        else{
            $log = 'Default values cannot be removed';
        }
        $status = $statusRepository->findAll();
        
        return $this->renderForm('remember/status.html.twig',['status' => $status, 'log' => $log]);
    }
}