<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\CardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CardRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Card
{
    use UpdatedAtTrait;
    use CreatedAtTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, mappedBy="card")
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="card")
     */
    private $usersCard;

    /**
     * @ORM\ManyToOne(targetEntity=Tab::class, inversedBy="cards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tab;

    /**
     * @ORM\OneToMany(targetEntity=Commentary::class, mappedBy="card")
     */
    private $commentaries;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->usersCard = new ArrayCollection();
        $this->commentaries = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addCard($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeCard($this);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsersCard(): Collection
    {
        return $this->usersCard;
    }

    public function addUsersCard(User $usersCard): self
    {
        if (!$this->usersCard->contains($usersCard)) {
            $this->usersCard[] = $usersCard;
            $usersCard->addCard($this);
        }

        return $this;
    }

    public function removeUsersCard(User $usersCard): self
    {
        if ($this->usersCard->removeElement($usersCard)) {
            $usersCard->removeCard($this);
        }

        return $this;
    }

    public function getTab(): ?Tab
    {
        return $this->tab;
    }

    public function setTab(?Tab $tab): self
    {
        $this->tab = $tab;

        return $this;
    }

    /**
     * @return Collection|Commentary[]
     */
    public function getCommentaries(): Collection
    {
        return $this->commentaries;
    }

    public function addCommentary(Commentary $commentary): self
    {
        if (!$this->commentaries->contains($commentary)) {
            $this->commentaries[] = $commentary;
            $commentary->setCard($this);
        }

        return $this;
    }

    public function removeCommentary(Commentary $commentary): self
    {
        if ($this->commentaries->removeElement($commentary)) {
            // set the owning side to null (unless already changed)
            if ($commentary->getCard() === $this) {
                $commentary->setCard(null);
            }
        }

        return $this;
    }
}
