<?php

namespace App\Service;

use App\Repository\BoxRepository;
use App\Repository\RecallRepository;
use App\Entity\Recall;
use App\Entity\Status;
use Doctrine\Persistence\ManagerRegistry;

class FormManager
{
    private $boxRepository;
    private $recallRepository;
    private $doctrine;

    function __construct(BoxRepository $box, RecallRepository $recall, ManagerRegistry $doctrine)
    {
        $this->boxRepository = $box;
        $this->recallRepository = $recall;
        $this->doctrine = $doctrine;
    }

    public function getItems()
    {
        $boxes = $this->boxRepository->findAll();
        $recalls = $this->recallRepository->findBy([],['status' => 'DESC']);
        return ['boxes' => $boxes, 'recalls' => $recalls];
    }

    public function addRecall(string $name)
    {
        $recall = new Recall();
        $box = $this->boxRepository->findOneBy(['name' => $name]);
        $recall->setName('new recall');
        $recall->setStatus('progress');
        $recall->setTargetBox($box);
        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($recall);
        $entityManager->flush();
        return 'new recall added in '.$name;
    }

    public function editRecallStatus(string $status, int $id) : void
    {
        $entityManager = $this->doctrine->getManager();
        $urgentRecall = $entityManager->getRepository(Recall::class)->find($id);
        $state = $entityManager->getRepository(Status::class)->findOneBy(['name' => $status]);
        $urgentRecall->setStatus($state->getName());
        $urgentRecall->setState($state);
        $entityManager->flush();
        return;
    }

}