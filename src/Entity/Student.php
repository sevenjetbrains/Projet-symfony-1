<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentRepository")
 * @ORM\Entity
 * @UniqueEntity(
 * fields={"email"},
 * message="cet etudiant existe déja"
 * )
 */
class Student implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez remplir ce champ")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez remplir ce champ")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez remplir ce champ")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez remplir ce champ")
     */
    private $hash;

    /**
     * Undocumented variable
     *
     * @Assert\NotBlank(message="Vous devez remplir ce champ")
     *  
     * @Assert\EqualTo(propertyPath="hash" ,message="erreur dans le mot de passe")
     */
     
    private $confirm;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ListExercise", mappedBy="studentTry")
     */
    private $listExercises;

    public function getCompletName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function __construct()
    {
        $this->listExercises = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

  

    /**
     * Get the value of confirm
     */ 
    public function getConfirm()
    {
        return $this->confirm;
    }

    /**
     * Set the value of confirm
     *
     * @return  self
     */ 
    public function setConfirm($confirm)
    {
        $this->confirm = $confirm;

        return $this;
    }

    /**
     * Get the value of hash
     */ 
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set the value of hash
     *
     * @return  self
     */ 
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    //------------------

    public function getRoles()
    {
        return ['ROLE_STUDENT'];
    }
    public function getPassword()
    {
        return $this->hash;
    }
    public function getSalt()
    {
    }
    public function getUsername()
    {
        return $this->email;
    }
    public function eraseCredentials()
    {
    }

    /**
     * @return Collection|ListExercise[]
     */
    public function getListExercises(): Collection
    {
        return $this->listExercises;
    }

    public function addListExercise(ListExercise $listExercise): self
    {
        if (!$this->listExercises->contains($listExercise)) {
            $this->listExercises[] = $listExercise;
            $listExercise->setStudentTry($this);
        }

        return $this;
    }

    public function removeListExercise(ListExercise $listExercise): self
    {
        if ($this->listExercises->contains($listExercise)) {
            $this->listExercises->removeElement($listExercise);
            // set the owning side to null (unless already changed)
            if ($listExercise->getStudentTry() === $this) {
                $listExercise->setStudentTry(null);
            }
        }

        return $this;
    }
}
