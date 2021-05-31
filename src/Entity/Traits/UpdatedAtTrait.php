<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trait UpdatedAtTrait.
 */
trait UpdatedAtTrait
{
    /**
     * @ORM\Column(name="updated_at", type="datetime_immutable", nullable=false, options={"default": "CURRENT_TIMESTAMP"})
     */
    private $updatedAt;

    /**
     * Set updatedAt.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdatedAt(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    /**
     * Get updatedAt.
     */
    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }
}
