<?php

namespace App\VehicleFleet\App\Command\ParkVehicle;

use App\Shared\Domain\Bus\Command\CommandHandlerInterface;
use App\VehicleFleet\Domain\Repository\LocationRepositoryInterface;
use App\VehicleFleet\Domain\Repository\VehicleRepositoryInterface;

/**
 * Class ParkVehicleCommandHandler
 */
final class ParkVehicleCommandHandler implements CommandHandlerInterface
{
    /**
     * @param LocationRepositoryInterface $locationRepositoryInterface
     * @param VehicleRepositoryInterface  $vehicleRepositoryInterface
     */
    public function __construct(
        private readonly LocationRepositoryInterface $locationRepositoryInterface,
        private readonly VehicleRepositoryInterface $vehicleRepositoryInterface
    ) {
    }

    /**
     * @param ParkVehicleCommand $parkVehicleCommand
     *
     * @return void
     */
    public function __invoke(ParkVehicleCommand $parkVehicleCommand): void
    {
        $vehicle = $this->vehicleRepositoryInterface->findOneBy(
            ['vehiclePlateNumber' => $parkVehicleCommand->getVehiclePlateNumber()]
        );
        if (null === $vehicle) {
            throw new \InvalidArgumentException(
                sprintf('Vehicle %s does not exist', $parkVehicleCommand->getVehiclePlateNumber())
            );
        }

        $location = $this->locationRepositoryInterface->findOneBy(
            ['vehicle' => $vehicle->getId(), 'fleet' => $parkVehicleCommand->getFleetId()]
        );
        if (null === $location) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Vehicle %s was not registered into fleet %d',
                    $vehicle->getVehiclePlateNumber(),
                    $parkVehicleCommand->getFleetId(),
                )
            );
        }
        if (null !== $this->locationRepositoryInterface->findOneBy(
            ['lat' => $parkVehicleCommand->getLat(), 'lng' => $parkVehicleCommand->getLng()]
        )) {
            throw new \InvalidArgumentException(
                sprintf(
                    'A vehicle is already park at this location lat %s and lng %s',
                    $parkVehicleCommand->getLat(),
                    $parkVehicleCommand->getLng(),
                )
            );
        }
        $location->setLat($parkVehicleCommand->getLat());
        $location->setLng($parkVehicleCommand->getLng());
        $this->locationRepositoryInterface->save($location);
    }
}
