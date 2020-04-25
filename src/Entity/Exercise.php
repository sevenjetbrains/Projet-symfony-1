<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExerciseRepository")
 * @UniqueEntity(
 * fields={"title"},
 * message="un cour avec ce tite existe déja"
 * )
 * @ORM\HasLifecycleCallbacks
 */
class Exercise
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $type;

    /**
     * @ORM\Column(type="date")
     * 
     */
    private $dateCreate;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Vous devez remplir ce champ")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Classes", inversedBy="exercise")
     */
    private $classes;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez remplir ce champ")
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Lines", mappedBy="exercise", orphanRemoval=true)
     * 
     * @Assert\Valid()
     *
     */
    private $linesExercise;

    public function __construct()
    {
        $this->linesExercise = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->dateCreate;
    }

    public function setDateCreate(\DateTimeInterface $dateCreate): self
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getClasses(): ?Classes
    {
        return $this->classes;
    }

    public function setClasses(?Classes $classes): self
    {
        $this->classes = $classes;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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
        if (empty($this->dateCreate)) {
            $this->dateCreate = new \DateTime();
        }
    }

    /**
     * @return Collection|Lines[]
     */
    public function getLinesExercise(): Collection
    {
        return $this->linesExercise;
    }

    public function addLinesExercise(Lines $linesExercise): self
    {
        if (!$this->linesExercise->contains($linesExercise)) {
            $this->linesExercise[] = $linesExercise;
            $linesExercise->setExercise($this);
        }

        return $this;
    }

    public function removeLinesExercise(Lines $linesExercise): self
    {
        if ($this->linesExercise->contains($linesExercise)) {
            $this->linesExercise->removeElement($linesExercise);
            // set the owning side to null (unless already changed)
            if ($linesExercise->getExercise() === $this) {
                $linesExercise->setExercise(null);
            }
        }

        return $this;
    }
}
