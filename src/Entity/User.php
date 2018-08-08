<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $adresses;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $zipCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $country;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Command", mappedBy="code")
     */
    protected $code_user;

    public function __construct()
    {
        $this->code_user = new ArrayCollection();
        parent::__construct();
    }


    public function getId()
    {
        return $this->id;
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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getAdresses(): ?string
    {
        return $this->adresses;
    }

    public function setAdresses(string $adresses): self
    {
        $this->adresses = $adresses;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection|Command[]
     */
    public function getCodeUser(): Collection
    {
        return $this->code_user;
    }

    public function addCodeUser(Command $codeUser): self
    {
        if (!$this->code_user->contains($codeUser)) {
            $this->code_user[] = $codeUser;
            $codeUser->setCode($this);
        }

        return $this;
    }

    public function removeCodeUser(Command $codeUser): self
    {
        if ($this->code_user->contains($codeUser)) {
            $this->code_user->removeElement($codeUser);
            // set the owning side to null (unless already changed)
            if ($codeUser->getCode() === $this) {
                $codeUser->setCode(null);
            }
        }

        return $this;
    }

}
