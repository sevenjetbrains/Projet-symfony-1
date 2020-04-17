<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClassesRepository")
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
     */
    private $title;

    /**
     * @ORM\Column(type="date")
     */
    private $dateCreate;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Teacher", inversedBy="classes")
     */
    private $author;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?\DateTimeInterface
    {
        return $this->title;
    }

    public function setTitle(\DateTimeInterface $title): self
    {
        $this->title = $title;

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
}
