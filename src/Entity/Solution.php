<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ExerciseRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SolutionRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Solution
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titleExercise;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Exercise", inversedBy="solutions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $exercise;

    /**
     * @ORM\Column(type="simple_array")
     */
    private $solutionArray = [];

    private $repo;

public function __construct( $repo){
$this->repo=$repo;
}
    /**
 *Callback appelé à chaque fois qu'on créé une soltion
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
public function generateTitle(){
    if(empty($titleExercise)){
       $result=$this->repo->find($this->exercise->getId());
       $nb=count($result->getSolutions());
       $this->titleExercise="solution 0".($nb + 1);
    }
    
}



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleExercise(): ?string
    {
        return $this->titleExercise;
    }

    public function setTitleExercise(string $titleExercise): self
    {
        $this->titleExercise = $titleExercise;

        return $this;
    }

    public function getExercise(): ?Exercise
    {
        return $this->exercise;
    }

    public function setExercise(?Exercise $exercise): self
    {
        $this->exercise = $exercise;

        return $this;
    }

    public function getSolutionArray(): ?array
    {
        return $this->solutionArray;
    }

    public function setSolutionArray(array $solutionArray): self
    {
        $this->solutionArray = $solutionArray;

        return $this;
    }
}
