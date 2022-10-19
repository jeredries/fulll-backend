<?php

declare(strict_types=1);

namespace App\VehicleFleet\App\Command\RegisterVehicle;

use App\Shared\Domain\Bus\Command\CommandInterface;

/**
 * Class RegisterVehicleCommand
 */
final class RegisterVehicleCommand implements CommandInterface
{
    /**
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
