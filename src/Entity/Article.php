<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    const ARTICLES_PER_PAGE = 3;
    const ARTICLES_IN_HOMEPAGE = 3;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="article", cascade={"persist"}, orphanRemoval=true)
     */
    private $images;

    public function __construct()
    {
        $this->date =new \DateTime();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): self
    {
        $this->date = $date;

        return $this;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getLimitedText() {
        $description=$this->getContent();

        $lg_max = 200; // nombre de caractère autorisé
        $description = strip_tags($description); // On retire toutes les balises
        if (strlen($description) > $lg_max) {
            $description = substr($description, 0, $lg_max) ;
            $last_space = strrpos($description, " ") ;
            $description = substr($description, 0, $last_space)."..." ;
        }

        return $description ;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Add image
     *
     * @param \App\Entity\Image $image
     *
     * @return Article
     */
    public function addImage(\App\Entity\Image $image)
    {
        $this->images[] = $image;
        $image->setArticle($this);

        return $this;
    }

    /**
     * Remove image
     *
     * @param \App\Entity\Image $image
     */
    public function removeImage(\App\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }


    public function getFirstImage(){
        $first = $this->images->first();
        return ($first)? $first->getImage(): null;
    }
}
