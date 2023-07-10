<?php

namespace App\Entity;

use App\Repository\SellersProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SellersProductsRepository::class)
 */
class SellersProducts
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $seller_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $product_id;

    /**
     * @ORM\ManyToMany(targetEntity=Products::class, inversedBy="sellersProducts")
     */
    private $Sellers;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sold;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shop_name;

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

    public function setSellerId(int $seller_id): self
    {
        $this->seller_id = $seller_id;

        return $this;
    }

    public function getProductId(): ?int
    {
        return $this->product_id;
    }

    public function setProductId(int $product_id): self
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

    public function addSeller(Products $seller): self
    {
        if (!$this->Sellers->contains($seller)) {
            $this->Sellers[] = $seller;
        }

        return $this;
    }

    public function removeSeller(Products $seller): self
    {
        $this->Sellers->removeElement($seller);

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

    public function getSold(): ?int
    {
        return $this->sold;
    }

    public function setSold(?int $sold): self
    {
        $this->sold = $sold;

        return $this;
    }

    public function getShopName(): ?string
    {
        return $this->shop_name;
    }

    public function setShopName(string $shop_name): self
    {
        $this->shop_name = $shop_name;

        return $this;
    }
}
