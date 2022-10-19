<?php

namespace App\VehicleFleet\Domain\Entity;

/**
 * Class Location
 */
class Location
{
    /**
     * @var int|null
     */
    private ?int $id = null;

    /**
     * @var Vehicle
     */
    private Vehicle $vehicle;

    /**
     * @var Fleet
     */
    private Fleet $fleet;

    /**
     * @var string|null
     */
    private ?string $lat = null;

    /**
     * @var string|null
     */
    private ?string $lng = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Vehicle
     */
    public function getVehicle(): Vehicle
    {
        return $this->vehicle;
    }

    /**
     * @param Vehicle $vehicle
     */
    public function setVehicle(Vehicle $vehicle): void
    {
        $this->vehicle = $vehicle;
    }

    /**
     * @return Fleet
     */
    public function getFleet(): Fleet
    {
        return $this->fleet;
    }

    /**
     * @param Fleet $fleet
     */
    public function setFleet(Fleet $fleet): void
    {
        $this->fleet = $fleet;
    }

    /**
     * @return string|null
     */
    public function getLat(): ?string
    {
        return $this->lat;
    }

    /**
     * @param string|null $lat
     */
    public function setLat(?string $lat): void
    {
        $this->lat = $lat;
    }

    /**
     * @return string|null
     */
    public function getLng(): ?string
    {
        return $this->lng;
    }

    /**
     * @param string|null $lng
     */
    public function setLng(?string $lng): void
    {
        $this->lng = $lng;
    }
}
