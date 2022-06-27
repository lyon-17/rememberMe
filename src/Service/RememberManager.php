<?php

namespace App\Service;

use App\Repository\BoxRepository;
use App\Repository\RecallRepository;
use App\Entity\Recall;
use App\Entity\Status;
use App\Entity\Box;
use App\Repository\StatusRepository;
use Doctrine\Persistence\ManagerRegistry;

class RememberManager
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

    /**
     * Get all the items from the database ordered in an array
     */

    public function getItems()
    {
        $boxes = $this->boxRepository->findAll();
        $recalls = $this->recallRepository->getRecalls();
        return ['boxes' => $boxes, 'recalls' => $recalls];
    }
    /**
     * Delete a box and their recalls from the database
     * @param int $id id of the box to be removed
     */
    public function removeBox(int $id)
    {
        $entityManager = $this->doctrine->getManager();
        $deleteBox = $entityManager->getRepository(Box::class)->find($id);
        $deleteRecalls = $entityManager->getRepository(Recall::class)->findBy(['target_box' => $id]);
        foreach ($deleteRecalls as $key => $value) {
            $entityManager->remove($value);
        }
        $entityManager->remove($deleteBox);
        $entityManager->flush();
    }

    /**
     * Add a new recall with a default name to a box
     * @param string $name name of the box
     */

    public function addRecall(string $name)
    {
        $recall = new Recall();
        $recall->setName('new recall');
        $recall->setStatus($this->statusRepository->getMain()->getName());
        $recall->setDescription('');
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

    public function deleteRecall($id)
    {
        $entityManager = $this->doctrine->getManager();
        $deleteRecall = $entityManager->getRepository(Recall::class)->find($id);
        $entityManager->remove($deleteRecall);
        $entityManager->flush();
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