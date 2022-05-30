<?php

namespace App\Entity;

use App\Repository\TachesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TachesRepository::class)
 */
class Taches
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Priority;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nom;

    /**
     * @ORM\ManyToOne(targetEntity=Listes::class, inversedBy="taches")
     */
    private $Listes;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active = false;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getPriority(): ?string
    {
        return $this->Priority;
    }

    public function setPriority(?string $Priority): self
    {
        $this->Priority = $Priority;

        return $this;
    }


    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getListes(): ?Listes
    {
        return $this->Listes;
    }

    public function setListes(?Listes $Listes): self
    {
        $this->Listes = $Listes;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

}
