<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeacherRepository")
 * @ORM\Entity
 * @UniqueEntity(
 * fields={"email"},
 * message="cet etudiant existe déja"
 * )
 */
class Teacher implements UserInterface
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
     * @ORM\OneToMany(targetEntity="App\Entity\Classes", mappedBy="author")
     */
    private $classes;

    public function __construct()
    {
        $this->classes = new ArrayCollection();
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
        return ['ROLE_TEACHER'];
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
     * @return Collection|Classes[]
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(Classes $class): self
    {
        if (!$this->classes->contains($class)) {
            $this->classes[] = $class;
            $class->setAuthor($this);
        }

        return $this;
    }

    public function removeClass(Classes $class): self
    {
        if ($this->classes->contains($class)) {
            $this->classes->removeElement($class);
            // set the owning side to null (unless already changed)
            if ($class->getAuthor() === $this) {
                $class->setAuthor(null);
            }
        }

        return $this;
    }
}
