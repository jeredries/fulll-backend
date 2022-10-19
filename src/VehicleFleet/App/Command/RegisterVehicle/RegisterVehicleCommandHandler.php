<?php

declare(strict_types=1);

namespace App\VehicleFleet\App\Command\RegisterVehicle;

use App\Shared\Domain\Bus\Command\CommandHandlerInterface;
use App\VehicleFleet\Domain\Entity\Location;
use App\VehicleFleet\Domain\Entity\Vehicle;
use App\VehicleFleet\Domain\Repository\FleetRepositoryInterface;
use App\VehicleFleet\Domain\Repository\LocationRepositoryInterface;
use App\VehicleFleet\Domain\Repository\VehicleRepositoryInterface;

/**
 * Class RegisterVehicleCommandHandler
 */
final class RegisterVehicleCommandHandler implements CommandHandlerInterface
{
    /**
     * @param FleetRepositoryInterface    $fleetRepositoryInterface
     * @param LocationRepositoryInterface $locationRepositoryInterface
     * @param VehicleRepositoryInterface  $vehicleRepositoryInterface
     */
    public function __construct(
        private readonly FleetRepositoryInterface $fleetRepositoryInterface,
        private readonly LocationRepositoryInterface $locationRepositoryInterface,
        private readonly VehicleRepositoryInterface $vehicleRepositoryInterface,
    ) {
    }

    /**
     * @param RegisterVehicleCommand $registerVehicleCommand
     *
     * @return void
     */
    public function __invoke(RegisterVehicleCommand $registerVehicleCommand): void
    {
        $fleet = $this->fleetRepositoryInterface->find($registerVehicleCommand->getFleetId());
        if (null === $fleet) {
            throw new \InvalidArgumentException(
                sprintf('Fleet %d does not exist', $registerVehicleCommand->getFleetId())
            );
        }

        $vehicle = $this->vehicleRepositoryInterface->findOneBy(
            ['vehiclePlateNumber' => $registerVehicleCommand->getVehiclePlateNumber()]
        );
        if (null === $vehicle) {
            $vehicle = new Vehicle();
            $vehicle->setVehiclePlateNumber($registerVehicleCommand->getVehiclePlateNumber());

            $this->vehicleRepositoryInterface->save($vehicle, false);
        }

        if (null !== $this->locationRepositoryInterface->findOneBy([
            'vehicle' => $vehicle->getId(),
            'fleet'   => $fleet->getId(),
        ])) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Vehicle %s is already registered into fleet %d',
                    $vehicle->getVehiclePlateNumber(),
                    $fleet->getId(),
                )
            );
        }
        $location = new Location();
        $location->setVehicle($vehicle);
        $location->setFleet($fleet);

        $this->locationRepositoryInterface->save($location);
    }
}
