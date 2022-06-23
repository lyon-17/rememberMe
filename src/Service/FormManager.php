<?php

namespace App\Service;

use App\Repository\BoxRepository;
use App\Repository\RecallRepository;
use App\Entity\Recall;
use App\Entity\Status;
use App\Repository\StatusRepository;
use Doctrine\Persistence\ManagerRegistry;

class FormManager
{
    private $boxRepository;
    private $recallRepository;
    private $statusRepository;
    private $doctrine;

    function __construct(BoxRepository $box, RecallRepository $recall, StatusRepository $status, ManagerRegistry $doctrine)
    {
        $this->boxRepository = $box;
        $this->recallRepository = $recall;
        $this->statusRepository = $status;
        $this->doctrine = $doctrine;
    }

    public function getItems()
    {
        $boxes = $this->boxRepository->findAll();
        $recalls = $this->recallRepository->getRecalls();
        return ['boxes' => $boxes, 'recalls' => $recalls];
    }

    public function addRecall(string $name)
    {
        $recall = new Recall();
        $recall->setName('new recall');
        $recall->setStatus($this->statusRepository->getMain()->getName());
        $box = $this->boxRepository->findOneBy(['name' => $name]);
        $state = $this->statusRepository->findOneBy(['name' => $recall->getStatus()]);
        $recall->setState($state);
        $recall->setTargetBox($box);
        $state->setName($recall->getStatus());
        
        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($recall);
        $entityManager->flush();
        return 'new recall added in '.$name;
    }
    /**
     * Given an status and recall id changes the recall state
     * @param string $status name of the state to change
     * @param int $id id of the recall
     */

    public function editRecallStatus(string $status, int $id) : void
    {
        $entityManager = $this->doctrine->getManager();
        $editRecall = $entityManager->getRepository(Recall::class)->find($id);
        $state = $entityManager->getRepository(Status::class)->findOneBy(['name' => $status]);
        $editRecall->setStatus($state->getName());
        $editRecall->setState($state);
        $entityManager->flush();
        return;
    }

}