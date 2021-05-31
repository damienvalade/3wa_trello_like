<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Repository\ChatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChatRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Chat
{
    use CreatedAtTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="chat")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userChat;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="chats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getUserChat(): ?User
    {
        return $this->userChat;
    }

    public function setUserChat(?User $userChat): self
    {
        $this->userChat = $userChat;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }
}
