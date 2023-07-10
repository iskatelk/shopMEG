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
    private $title;

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
    private $model;

    /**
     * @ORM\Column(type="integer")
     */
    private $product_id;

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

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
