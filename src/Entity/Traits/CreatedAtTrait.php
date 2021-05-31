<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

trait CreatedAtTrait
{
    /**
     * @ORM\Column(name="created_at", type="datetime_immutable", nullable=false, options={"default": "CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * Se déclenche uniquement sur l'insertion.
     *
     * @ORM\PrePersist
     */
    public function setCreatedAt(): void
    {
        $this->createdAt = new DateTimeImmutable();
    }

    /**
     * Get createdAt.
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }
}
