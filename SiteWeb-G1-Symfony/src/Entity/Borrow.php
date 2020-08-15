<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\BorrowRepository")
 */
class Borrow
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $borrow_start;

    /**
     * @ORM\Column(type="datetime")
     */
    private $borrow_end;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="borrows")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipment", inversedBy="borrows")
     * @ORM\JoinColumn(nullable=false)
     */
    private $equipment;
    
    
    public $linker;
    
    public function __toString()
    {
        return $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBorrowStart(): ?\DateTimeInterface
    {
        return $this->borrow_start;
    }

    public function setBorrowStart(\DateTimeInterface $borrow_start): self
    {
        $this->borrow_start = $borrow_start;

        return $this;
    }

    public function getBorrowEnd(): ?\DateTimeInterface
    {
        return $this->borrow_end;
    }

    public function setBorrowEnd(\DateTimeInterface $borrow_end): self
    {
        $this->borrow_end = $borrow_end;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $available_quantity): self
    {
        $this->quantity = $available_quantity;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getEquipment(): ?Equipment
    {
        return $this->equipment;
    }

    public function setEquipment(?Equipment $equipment): self
    {
        $this->equipment = $equipment;

        return $this;
    }
    
    public function getLinker() :?string
    {
        return $this->linker;
    }
    
}
