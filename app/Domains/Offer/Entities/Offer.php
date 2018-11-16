<?php

namespace App\Domains\Offer\Entities;

use App\Domains\Product\Entities\Product;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Domains\Offer\Repository\OfferRepository")
 * @ORM\Table(name="offers")
 */
class Offer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

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
     * @ORM\Column(type="integer", nullable=true)
     * @var int
     */
    private $sales;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domains\Product\Entities\Product", inversedBy="offers")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * @var Product
     */
    private $product;

    /**
     * Offer constructor.
     *
     * @param int $id
     * @param float $price
     * @param int $amount
     * @param int|null $sales
     * @param null|string $article
     */
    public function __construct(int $id, float $price, int $amount, ?int $sales, ?string $article)
    {
        $this->id = $id;
        $this->price = $price;
        $this->amount = $amount;
        $this->sales = $sales;
        $this->article = $article;
    }

    /**
     * @param int $id
     * @param float $price
     * @param int $amount
     * @param int|null $sales
     * @param null|string $article
     * @return Offer
     */
    public static function build(int $id, float $price, int $amount, ?int $sales, ?string $article)
    {
        return new self($id, $price, $amount, $sales, $article);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return int|null
     */
    public function getSales(): ?int
    {
        return $this->sales;
    }

    /**
     * @param int|null $sales
     */
    public function setSales(?int $sales): void
    {
        $this->sales = $sales;
    }

    /**
     * @return null|string
     */
    public function getArticle(): ?string
    {
        return $this->article;
    }

    /**
     * @param null|string $article
     */
    public function setArticle(?string $article): void
    {
        $this->article = $article;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }
}