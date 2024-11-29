<?php

namespace OHMedia\MetaBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Proxy;
use OHMedia\FileBundle\Entity\File;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Meta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?File $image = null;

    #[ORM\Column]
    private ?bool $append_base_title = null;

    public function __clone()
    {
        if ($this->id) {
            if ($this instanceof Proxy && !$this->__isInitialized()) {
                // Initialize the proxy to load all properties
                $this->__load();
            }

            $this->id = null;

            if ($this->image) {
                $this->image = clone $this->image;
            }
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?File
    {
        return $this->image;
    }

    public function setImage(?File $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getAppendBaseTitle(): ?bool
    {
        return $this->append_base_title;
    }

    public function setAppendBaseTitle(bool $append_base_title): self
    {
        $this->append_base_title = $append_base_title;

        return $this;
    }
}
