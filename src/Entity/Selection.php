<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SelectionRepository")
 */
class Selection
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Tableau
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tableau")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tableau1;

    /**
     * @var Tableau
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tableau")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tableau2;

    /**
     * @var Tableau
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tableau")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tableau3;

    /**
     * @var Tableau
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tableau")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tableau4;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTableau1(): ?Tableau
    {
        return $this->tableau1;
    }

    public function setTableau1(?Tableau $tableau1): self
    {
        $this->tableau1 = $tableau1;

        return $this;
    }

    public function getTableau2(): ?Tableau
    {
        return $this->tableau2;
    }

    public function setTableau2(?Tableau $tableau2): self
    {
        $this->tableau2 = $tableau2;

        return $this;
    }

    public function getTableau3(): ?Tableau
    {
        return $this->tableau3;
    }

    public function setTableau3(?Tableau $tableau3): self
    {
        $this->tableau3 = $tableau3;

        return $this;
    }

    public function getTableau4(): ?Tableau
    {
        return $this->tableau4;
    }

    public function setTableau4(?Tableau $tableau4): self
    {
        $this->tableau4 = $tableau4;

        return $this;
    }

    public function contains(Tableau $tableau)
    {
        return in_array($tableau->getId(), [
            $this->tableau1->getId(),
            $this->tableau2->getId(),
            $this->tableau3->getId(),
            $this->tableau4->getId(),
        ]);
    }
}
