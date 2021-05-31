<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface
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
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Chat::class, mappedBy="userChat", orphanRemoval=true)
     */
    private $chat;

    /**
     * @ORM\ManyToMany(targetEntity=Project::class, inversedBy="users")
     */
    private $projects;

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="userProject")
     */
    private $project;

    /**
     * @ORM\OneToMany(targetEntity=Commentary::class, mappedBy="userCommentary")
     */
    private $commentary;

    /**
     * @ORM\ManyToMany(targetEntity=Card::class, inversedBy="usersCard")
     */
    private $card;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    public function __construct()
    {
        $this->chat = new ArrayCollection();
        $this->projects = new ArrayCollection();
        $this->project = new ArrayCollection();
        $this->commentary = new ArrayCollection();
        $this->card = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): self
    {
        $this->img = $img;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Chat[]
     */
    public function getChat(): Collection
    {
        return $this->chat;
    }

    public function addChat(Chat $chat): self
    {
        if (!$this->chat->contains($chat)) {
            $this->chat[] = $chat;
            $chat->setUserChat($this);
        }

        return $this;
    }

    public function removeChat(Chat $chat): self
    {
        if ($this->chat->removeElement($chat)) {
            // set the owning side to null (unless already changed)
            if ($chat->getUserChat() === $this) {
                $chat->setUserChat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        $this->projects->removeElement($project);

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProject(): Collection
    {
        return $this->project;
    }

    /**
     * @return Collection|Commentary[]
     */
    public function getCommentary(): Collection
    {
        return $this->commentary;
    }

    public function addCommentary(Commentary $commentary): self
    {
        if (!$this->commentary->contains($commentary)) {
            $this->commentary[] = $commentary;
            $commentary->setUserCommentary($this);
        }

        return $this;
    }

    public function removeCommentary(Commentary $commentary): self
    {
        if ($this->commentary->removeElement($commentary)) {
            // set the owning side to null (unless already changed)
            if ($commentary->getUserCommentary() === $this) {
                $commentary->setUserCommentary(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|card[]
     */
    public function getCard(): Collection
    {
        return $this->card;
    }

    public function addCard(card $card): self
    {
        if (!$this->card->contains($card)) {
            $this->card[] = $card;
        }

        return $this;
    }

    public function removeCard(card $card): self
    {
        $this->card->removeElement($card);

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
