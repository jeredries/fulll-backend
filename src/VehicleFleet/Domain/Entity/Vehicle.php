<?php

namespace App\VehicleFleet\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class Vehicle
 */
class Vehicle
{
    /**
     * @var int|null
     */
    private ?int $id = null;

    /**
     * @var string
     */
    private string $vehiclePlateNumber;

    /**
     * @var Collection<int, Location>
     */
    private Collection $locations;

    /**
     * Vehicle constructor.
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
     * @return string
     */
    public function getVehiclePlateNumber(): string
    {
        return $this->vehiclePlateNumber;
    }

    /**
     * @param string $vehiclePlateNumber
     */
    public function setVehiclePlateNumber(string $vehiclePlateNumber): void
    {
        $this->vehiclePlateNumber = $vehiclePlateNumber;
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
