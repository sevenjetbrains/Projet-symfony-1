<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ListExerciseRepository")
 *  @ORM\HasLifecycleCallbacks
 */
class ListExercise
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nomberTry;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Student", inversedBy="listExercises")
     * @ORM\JoinColumn(nullable=false)
     */
    private $studentTry;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status=false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Exercise", inversedBy="listStudentTry")
     * @ORM\JoinColumn(nullable=false)
     */
    private $exercise;

    /**
     * @ORM\Column(type="boolean")
     */
    private $try;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomberTry(): ?int
    {
        return $this->nomberTry;
    }

    public function setNomberTry(?int $nomberTry): self
    {
        $this->nomberTry = $nomberTry;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStudentTry(): ?Student
    {
        return $this->studentTry;
    }

    public function setStudentTry(?Student $studentTry): self
    {
        $this->studentTry = $studentTry;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

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


    //-----------------------------------------------------
    /**
     * Callback appelé à chaque fois qu'on créé un Cour
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function prePersist()
    {
        if (empty($this->date)) {
            $this->date = new \DateTime();
        }
    }

    public function getTry(): ?bool
    {
        return $this->try;
    }

    public function setTry(bool $try): self
    {
        $this->try = $try;

        return $this;
    }

}
