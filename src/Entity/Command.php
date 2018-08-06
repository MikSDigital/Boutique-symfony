<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandRepository")
 */
class Command
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateOfCommand;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="code_user")
     */
    private $code_user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="code_user")
     * @ORM\JoinColumn(nullable=false)
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LinesOfCommand", mappedBy="code_command")
     */
    private $numberOfCommand;


    public function __construct()
    {
        $this->code_user = new ArrayCollection();
        $this->numberOfCommand = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDateOfCommand(): ?\DateTimeInterface
    {
        return $this->dateOfCommand;
    }

    public function setDateOfCommand(\DateTimeInterface $dateOfCommand): self
    {
        $this->dateOfCommand = $dateOfCommand;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getCodeUser(): Collection
    {
        return $this->code_user;
    }

    public function addCodeUser(User $codeUser): self
    {
        if (!$this->code_user->contains($codeUser)) {
            $this->code_user[] = $codeUser;
            $codeUser->setCodeUser($this);
        }

        return $this;
    }

    public function removeCodeUser(User $codeUser): self
    {
        if ($this->code_user->contains($codeUser)) {
            $this->code_user->removeElement($codeUser);
            // set the owning side to null (unless already changed)
            if ($codeUser->getCodeUser() === $this) {
                $codeUser->setCodeUser(null);
            }
        }

        return $this;
    }

    public function getCode(): ?User
    {
        return $this->code;
    }

    public function setCode(?User $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection|LinesOfCommand[]
     */
    public function getNumberOfCommand(): Collection
    {
        return $this->numberOfCommand;
    }

    public function addNumberOfCommand(LinesOfCommand $numberOfCommand): self
    {
        if (!$this->numberOfCommand->contains($numberOfCommand)) {
            $this->numberOfCommand[] = $numberOfCommand;
            $numberOfCommand->setCodeCommand($this);
        }

        return $this;
    }

    public function removeNumberOfCommand(LinesOfCommand $numberOfCommand): self
    {
        if ($this->numberOfCommand->contains($numberOfCommand)) {
            $this->numberOfCommand->removeElement($numberOfCommand);
            // set the owning side to null (unless already changed)
            if ($numberOfCommand->getCodeCommand() === $this) {
                $numberOfCommand->setCodeCommand(null);
            }
        }

        return $this;
    }

}
