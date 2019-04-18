<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20, unique=true)
     * Validation : non vide
     * @Assert\NotBlank(message="Le nom est obligatoire")
     *
     * @Assert\Length(max="20",
     *     maxMessage="Le nom ne doit pas dépasser {{ limit }} caractères")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="category")
     */
    private $article;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Blog", mappedBy="category")
     */
    private $blogs;

    public function __construct()
    {
        $this->article = new ArrayCollection();
        $this->blogs = new ArrayCollection();
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

    public function __toString()
    {
        return $this->name;
    }


    /**
     * @return Collection|Article[]
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article[] = $article;
            $article->setCategory($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->article->contains($article)) {
            $this->article->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getCategory() === $this) {
                $article->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Blog[]
     */
    public function getBlogs(): Collection
    {
        return $this->blogs;
    }

    public function addBlog(Blog $blog): self
    {
        if (!$this->blogs->contains($blog)) {
            $this->blogs[] = $blog;
            $blog->setCategory($this);
        }

        return $this;
    }

    public function removeBlog(Blog $blog): self
    {
        if ($this->blogs->contains($blog)) {
            $this->blogs->removeElement($blog);
            // set the owning side to null (unless already changed)
            if ($blog->getCategory() === $this) {
                $blog->setCategory(null);
            }
        }

        return $this;
    }
}
