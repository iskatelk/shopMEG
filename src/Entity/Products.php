<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductsRepository::class)]
class Products
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 255)]
    private ?string $seller = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    /**
     * @ORM\ManyToMany(targetEntity=SellersProducts::class, mappedBy="Sellers")
     */
    #[ORM\ManyToMany(targetEntity: SellersProducts::class, mappedBy: 'Sellers')]
    private Collection $sellersProducts;

//    #[ORM\ManyToOne]
//    #[ORM\JoinColumn(nullable: false)]
//    private ?Category $category = null;

    public function __construct()
    {
        $this->sellersProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getSeller(): ?string
    {
        return $this->seller;
    }

    public function setSeller(string $seller): static
    {
        $this->seller = $seller;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, SellersProducts>
     */
    public function getSellersProducts(): Collection
    {
        return $this->sellersProducts;
    }

    public function addSellersProduct(SellersProducts $sellersProduct): static
    {
        if (!$this->sellersProducts->contains($sellersProduct)) {
            $this->sellersProducts[] = $sellersProduct;
            $sellersProduct->addSeller($this);
        }

        return $this;
    }

    public function removeSellersProduct(SellersProducts $sellersProduct): static
    {
        if ($this->sellersProducts->removeElement($sellersProduct)) {
            $sellersProduct->removeSeller($this);
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }
}
