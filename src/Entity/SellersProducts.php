<?php

namespace App\Entity;

use App\Repository\SellersProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SellersProductsRepository::class)]
class SellersProducts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $seller_id = null;

    #[ORM\Column]
    private ?int $product_id = null;

    #[ORM\ManyToMany(targetEntity: Products::class, mappedBy: 'sellersProducts')]
    private Collection $Sellers;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column (nullable: true)]
    private ?int $sold;

    #[ORM\Column(length: 255)]
    private ?string $shop_name = null;

    public function __construct()
    {
        $this->Sellers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSellerId(): ?int
    {
        return $this->seller_id;
    }

    public function setSellerId(int $seller_id): static
    {
        $this->seller_id = $seller_id;

        return $this;
    }

    public function getProductId(): ?int
    {
        return $this->product_id;
    }

    public function setProductId(int $product_id): static
    {
        $this->product_id = $product_id;

        return $this;
    }

    /**
     * @return Collection<int, Products>
     */
    public function getSellers(): Collection
    {
        return $this->Sellers;
    }

    public function addSeller(Products $seller): static
    {
        if (!$this->Sellers->contains($seller)) {
            $this->Sellers[] = $seller;
        }

        return $this;
    }

    public function removeSeller(Products $seller): static
    {
        $this->Sellers->removeElement($seller);

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

    public function getSold(): ?int
    {
        return $this->sold;
    }

    public function setSold(?int $sold): static
    {
        $this->sold = $sold;

        return $this;
    }

    public function getShopName(): ?string
    {
        return $this->shop_name;
    }

    public function setShopName(string $shop_name): static
    {
        $this->shop_name = $shop_name;

        return $this;
    }
}
