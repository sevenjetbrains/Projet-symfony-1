<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClassesRepository")
 *  @ORM\Entity
 * @UniqueEntity(
 * fields={"title"},
 * message="un cour avec ce tite existe déja"
 * )
 * @ORM\HasLifecycleCallbacks
 */
class Classes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Vous devez remplir ce champ")
     * @Assert\Length(min=10,max=255,minMessage="Le titre doit faire plus de 10 caractéres !",
     * maxMessage="Le titre ne peut pas faire plus de 255 caractéres")
     */
    private $title;

    /**
     * @ORM\Column(type="date")
     */
    private $dateCreate;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Vous devez remplir ce champ")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Teacher", inversedBy="classes")
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $updateDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Exercise", mappedBy="classes",fetch="EAGER")
     */
    private $exercise;

   
    public function __construct()
    {
        $this->exercise = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): ?Teacher
    {
        return $this->author;
    }

    public function setAuthor(?Teacher $author): self
    {
        $this->author = $author;

        return $this;
    }


    
    
    
    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;
        
        return $this;
    }
    
    public function getSlug(): ?string
    {
        return $this->slug;
    }
    
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        
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
    //----------------------------------------------------------------
    /**
     * Permet d'initialiser le slug !
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * @return void
     */
    public function initializeSlug()
    {
        if (empty($this->slug)) {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->title);
        }
    }  
    //--------------------------------------------------------------   


    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->updateDate;
    }

    public function setUpdateDate(?\DateTimeInterface $updateDate): self
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * @return Collection|Exercise[]
     */
    public function getExercise(): Collection
    {
        return $this->exercise;
    }

    public function addExercise(Exercise $exercise): self
    {
        if (!$this->exercise->contains($exercise)) {
            $this->exercise[] = $exercise;
            $exercise->setClasses($this);
        }

        return $this;
    }

    public function removeExercise(Exercise $exercise): self
    {
        if ($this->exercise->contains($exercise)) {
            $this->exercise->removeElement($exercise);
            // set the owning side to null (unless already changed)
            if ($exercise->getClasses() === $this) {
                $exercise->setClasses(null);
            }
        }

        return $this;
    }}
