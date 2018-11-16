<?php

namespace App\Domains\Product\Entities;

use App\Domains\Category\Entities\Category;
use App\Domains\Offer\Entities\Offer;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Domains\Product\Repositories\ProductRepository")
 * @ORM\Table(
 *     name="products",
 *     indexes={
            @ORM\Index(columns={"title", "description"}, flags={"fulltext"})
 *     }
 * )
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $image;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTime
     */
    private $first_invoice;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $url;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @var float
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $amount;

    /**
     * @ORM\ManyToMany(targetEntity="App\Domains\Category\Entities\Category")
     * @ORM\JoinTable(name="products_categories",
     *     joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     *     )
     * @var Collection
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="App\Domains\Offer\Entities\Offer", mappedBy="product", cascade={"persist", "remove"})
     * @var Collection
     */
    private $offers;

    /**
     * Product constructor.
     *
     * @param int $id
     * @param string $title
     * @param string $image
     * @param string $description
     * @param DateTime|null $first_invoice
     * @param string $url
     * @param float $price
     * @param int $amount
     */
    public function __construct(
        int $id,
        string $title,
        string $image,
        string $description,
        ?DateTime $first_invoice,
        string $url,
        float $price,
        int $amount
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->image = $image;
        $this->description = $description;
        $this->first_invoice = $first_invoice;
        $this->url = $url;
        $this->price = $price;
        $this->amount = $amount;
        $this->categories = new ArrayCollection();
        $this->offers = new ArrayCollection();
    }

    /**
     * @param int $id
     * @param string $title
     * @param string $image
     * @param string $description
     * @param DateTime|null $first_invoice
     * @param string $url
     * @param float $price
     * @param string $amount
     * @return Product
     */
    public static function build(
        int $id,
        string $title,
        string $image,
        string $description,
        ?DateTime $first_invoice,
        string $url,
        float $price,
        string $amount
    )
    {
        return new self($id, $title, $image, $description, $first_invoice, $url, $price, $amount);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return DateTime|null
     */
    public function getFirstInvoice(): ?DateTime
    {
        return $this->first_invoice;
    }

    /**
     * @param DateTime|null $first_invoice
     */
    public function setFirstInvoice(?DateTime $first_invoice): void
    {
        $this->first_invoice = $first_invoice;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return Collection
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * @param Category $category
     */
    public function addCategory(Category $category): void
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }
    }

    /**
     * @param Category $category
     */
    public function removeCategory(Category $category): void
    {
        $this->categories->removeElement($category);
    }

    /**
     * @return Collection
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    /**
     * @param Offer $offer
     */
    public function addOffer(Offer $offer): void
    {
        if (!$this->offers->contains($offer)) {
            $this->offers->add($offer);
            $offer->setProduct($this);
        }
    }
}