<?php

namespace App\VehicleFleet\App\Query\LocalizeVehicle;

use App\Shared\Domain\Bus\Query\QueryInterface;

/**
 * Class LocalizeCommand
 */
final class LocalizeQuery implements QueryInterface
{
    /**
     * LocalizeQuery constructor.
     *
     * @param int    $fleetId
     * @param string $vehiclePlateNumber
     */
    public function __construct(private int $fleetId, private string $vehiclePlateNumber)
    {
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
}
