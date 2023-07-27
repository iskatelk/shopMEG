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

    #[ORM\OneToMany(mappedBy: 'products', targetEntity: Comment::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $comments;

    #[ORM\ManyToMany(targetEntity: Category::class)]
    private Collection $categories;

    #[ORM\OneToMany(mappedBy: 'products', targetEntity: Question::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $questions;

//    #[ORM\ManyToOne]
//    #[ORM\JoinColumn(nullable: false)]
//    private ?Category $category = null;

    public function __construct()
    {
        $this->sellersProducts = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->questions = new ArrayCollection();
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

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setProducts($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getProducts() === $this) {
                $comment->setProducts(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setProducts($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): static
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getProducts() === $this) {
                $question->setProducts(null);
            }
        }

        return $this;
    }
}
