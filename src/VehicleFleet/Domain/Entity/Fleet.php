<?php

namespace App\VehicleFleet\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class Fleet
 */
class Fleet
{
    /**
     * @var int|null
     */
    private ?int $id = null;

    /**
     * @var int
     */
    private int $userId;

    /**
     * @var Collection<int, Location>
     */
    private Collection $locations;

    /**
     * Fleet constructor.
     */
    public function __construct()
    {
        $this->locations = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return Collection
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    /**
     * @param Location $location
     */
    public function addLocation(Location $location): void
    {
        if (!$this->locations->contains($location)) {
            $this->locations->add($location);
        }
    }

    /**
     * @param Location $location
     */
    public function removeLocation(Location $location): void
    {
        if ($this->locations->contains($location)) {
            $this->locations->removeElement($location);
        }
    }
}
