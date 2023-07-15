<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductsRepository::class)
 */
class Products
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $seller;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=SellersProducts::class, mappedBy="Sellers")
     */
    private $sellersProducts;

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

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSeller(): ?string
    {
        return $this->seller;
    }

    public function setSeller(string $seller): self
    {
        $this->seller = $seller;

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

    /**
     * @return Collection<int, SellersProducts>
     */
    public function getSellersProducts(): Collection
    {
        return $this->sellersProducts;
    }

    public function addSellersProduct(SellersProducts $sellersProduct): self
    {
        if (!$this->sellersProducts->contains($sellersProduct)) {
            $this->sellersProducts[] = $sellersProduct;
            $sellersProduct->addSeller($this);
        }

        return $this;
    }

    public function removeSellersProduct(SellersProducts $sellersProduct): self
    {
        if ($this->sellersProducts->removeElement($sellersProduct)) {
            $sellersProduct->removeSeller($this);
        }

        return $this;
    }
}
