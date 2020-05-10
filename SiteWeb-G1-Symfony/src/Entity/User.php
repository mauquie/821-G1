<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Cette email existe deja")
 * @UniqueEntity(fields="username", message="Ce pseudo est deja pris")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max=100, maxMessage="Entrer un pseudo d'au moins {{ limit }} caracteres")
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max=100, maxMessage="Entrer un pseudo d'au moins {{ limit }} caracteres")
     * @Assert\NotBlank()
     */
    private $username;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=6, minMessage="Votre mot de passe doit contenir au moins {{ limit }} caracteres")
     */
    private $password;
    
    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Borrow", mappedBy="user", orphanRemoval=true)
     */
    private $borrows;

    public function __construct()
    {
        $this->borrows = new ArrayCollection();
    }
    
    public function __toString()
    {
        return $this->email;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function setEmail(string $email)
    {
        $this->email = $email;
    }
    
    public function getUsername()
    {
        return $this->username;
    }
    
    public function setUsername(string $username)
    {
        $this->username = $username;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    public function setPassword(string $password)
    {
        $this->password = $password;
    }
    
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        
        return array_unique($roles);
        
    }
    
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }
    
    public function getSalt()
    {
        return null;
    }
    
    public function eraseCredentials()
    {
    }

    /**
     * @return Collection|Borrow[]
     */
    public function getBorrows(): Collection
    {
        return $this->borrows;
    }

    public function addBorrow(Borrow $borrow): self
    {
        if (!$this->borrows->contains($borrow)) {
            $this->borrows[] = $borrow;
            $borrow->setUser($this);
        }

        return $this;
    }

    public function removeBorrow(Borrow $borrow): self
    {
        if ($this->borrows->contains($borrow)) {
            $this->borrows->removeElement($borrow);
            // set the owning side to null (unless already changed)
            if ($borrow->getUser() === $this) {
                $borrow->setUser(null);
            }
        }

        return $this;
    }
    
}