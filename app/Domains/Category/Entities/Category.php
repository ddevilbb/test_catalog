<?php

namespace App\Domains\Category\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Domains\Category\Repositories\CategoryRepository")
 * @ORM\Table(name="categories")
 */
class Category 
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
    private $alias;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent", referencedColumnName="id", nullable=true)
     * @var Category|null
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     * @ORM\OrderBy({"title"="ASC"})
     * @var Collection
     */
    private $children;

    /**
     * Category constructor.
     *
     * @param int $id
     * @param string $title
     * @param string $alias
     * @param Category|null $parent
     */
    public function __construct(int $id, string $title, string $alias, ?Category $parent)
    {
        $this->id = $id;
        $this->title = $title;
        $this->alias = $alias;
        $this->children = new ArrayCollection();
        $this->setParent($parent);
    }

    /**
     * @param int $id
     * @param string $title
     * @param string $alias
     * @param Category|null $parent
     * @return Category
     */
    public static function build(int $id, string $title, string $alias, ?Category $parent)
    {
        return new self($id, $title, $alias, $parent);
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
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     */
    public function setAlias(string $alias): void
    {
        $this->alias = $alias;
    }

    /**
     * @return Category|null
     */
    public function getParent(): ?Category
    {
        return $this->parent;
    }

    /**
     * @param Category|null $parent
     */
    public function setParent(?Category $parent): void
    {
        $this->parent = $parent;
        if (!is_null($parent)) {
            $parent->addChild($this);
        }
    }

    /**
     * @return Collection
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    /**
     * @param Category $category
     */
    public function addChild(Category $category)
    {
        $this->children->add($category);
    }
}