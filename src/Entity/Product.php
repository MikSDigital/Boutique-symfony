<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @Vich\Uploadable
 */
class Product
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
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @Gedmo\Slug(fields={"name"},separator="-", updatable=true, unique=true)
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="product", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName", size="imageSize")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $imageSize;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="product_image2", fileNameProperty="imageName2", size="imageSize2")
     *
     * @var File
     */
    private $imageFile2;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName2;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $imageSize2;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt2;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="product_image3", fileNameProperty="imageName3", size="imageSize3")
     *
     * @var File
     */
    private $imageFile3;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName3;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $imageSize3;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt3;


    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->code_product = new ArrayCollection();
        $this->createdAt = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->reference = uniqid('Ref');
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedAt2(): ?\DateTimeInterface
    {
        return $this->updatedAt2;
    }

    public function setUpdatedAt2(\DateTimeInterface $updatedAt2): self
    {
        $this->updatedAt2 = $updatedAt2;

        return $this;
    }

    public function getUpdatedAt3(): ?\DateTimeInterface
    {
        return $this->updatedAt3;
    }

    public function setUpdatedAt3(\DateTimeInterface $updatedAt3): self
    {
        $this->updatedAt3 = $updatedAt3;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return Collection|LinesOfCommand[]
     */
    public function getCodeProduct(): Collection
    {
        return $this->code_product;
    }

    public function addCodeProduct(LinesOfCommand $codeProduct): self
    {
        if (!$this->code_product->contains($codeProduct)) {
            $this->code_product[] = $codeProduct;
            $codeProduct->setCodeProduct($this);
        }

        return $this;
    }

    public function removeCodeProduct(LinesOfCommand $codeProduct): self
    {
        if ($this->code_product->contains($codeProduct)) {
            $this->code_product->removeElement($codeProduct);
            // set the owning side to null (unless already changed)
            if ($codeProduct->getCodeProduct() === $this) {
                $codeProduct->setCodeProduct(null);
            }
        }

        return $this;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     * @throws \Exception
     */
    public function setImageFile(?File $image = null): void
    {
        $this->imageFile = $image;

        if (null !== $image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image2
     * @throws \Exception
     */
    public function setImageFile2(?File $image2 = null): void
    {
        $this->imageFile2 = $image2;

        if (null !== $image2) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile2(): ?File
    {
        return $this->imageFile2;
    }

    public function setImageName2(?string $imageName2): void
    {
        $this->imageName2 = $imageName2;
    }

    public function getImageName2(): ?string
    {
        return $this->imageName2;
    }

    public function setImageSize2(?int $imageSize2): void
    {
        $this->imageSize2 = $imageSize2;
    }

    public function getImageSize2(): ?int
    {
        return $this->imageSize2;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image3
     * @throws \Exception
     */
    public function setImageFile3(?File $image3 = null): void
    {
        $this->imageFile3 = $image3;

        if (null !== $image3) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile3(): ?File
    {
        return $this->imageFile3;
    }

    public function setImageName3(?string $imageName3): void
    {
        $this->imageName3 = $imageName3;
    }

    public function getImageName3(): ?string
    {
        return $this->imageName3;
    }

    public function setImageSize3(?int $imageSize3): void
    {
        $this->imageSize3 = $imageSize3;
    }

    public function getImageSize3(): ?int
    {
        return $this->imageSize3;
    }


}
