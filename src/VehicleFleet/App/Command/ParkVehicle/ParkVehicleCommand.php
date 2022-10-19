<?php

namespace App\VehicleFleet\App\Command\ParkVehicle;

use App\Shared\Domain\Bus\Command\CommandInterface;

/**
 * Class ParkVehicleCommand
 */
final class ParkVehicleCommand implements CommandInterface
{
    /**
     * @param int    $fleetId
     * @param string $vehiclePlateNumber
     * @param string $lat
     * @param string $lng
     */
    public function __construct(
        private int $fleetId,
        private string $vehiclePlateNumber,
        private string $lat,
        private string $lng,
    ) {
    }

    /**
     * @return int
     */
    public function getFleetId(): int
    {
        return $this->fleetId;
    }

    /**
     * @param int $fleetId
     */
    public function setFleetId(int $fleetId): void
    {
        $this->fleetId = $fleetId;
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
     * @return string
     */
    public function getLat(): string
    {
        return $this->lat;
    }

    /**
     * @param string $lat
     */
    public function setLat(string $lat): void
    {
        $this->lat = $lat;
    }

    /**
     * @return string
     */
    public function getLng(): string
    {
        return $this->lng;
    }

    /**
     * @param string $lng
     */
    public function setLng(string $lng): void
    {
        $this->lng = $lng;
    }
}
