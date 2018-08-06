<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LinesOfCommandRepository")
 */
class LinesOfCommand
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $quantityOrdered;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Command", inversedBy="numberOfCommand")
     * @ORM\JoinColumn(nullable=false)
     */
    private $code_command;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="code_product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $code_product;


    public function getId()
    {
        return $this->id;
    }

    public function getQuantityOrdered(): ?string
    {
        return $this->quantityOrdered;
    }

    public function setQuantityOrdered(string $quantityOrdered): self
    {
        $this->quantityOrdered = $quantityOrdered;

        return $this;
    }

    public function getCodeCommand(): ?Command
    {
        return $this->code_command;
    }

    public function setCodeCommand(?Command $code_command): self
    {
        $this->code_command = $code_command;

        return $this;
    }

    public function getCodeProduct(): ?Product
    {
        return $this->code_product;
    }

    public function setCodeProduct(?Product $code_product): self
    {
        $this->code_product = $code_product;

        return $this;
    }
    
}
