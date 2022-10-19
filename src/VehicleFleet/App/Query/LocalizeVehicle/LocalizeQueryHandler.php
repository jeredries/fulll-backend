<?php

namespace App\VehicleFleet\App\Query\LocalizeVehicle;

use App\Shared\Domain\Bus\Query\QueryHandlerInterface;
use App\VehicleFleet\Domain\Entity\Location;
use App\VehicleFleet\Domain\Repository\LocationRepositoryInterface;
use App\VehicleFleet\Domain\Repository\VehicleRepositoryInterface;

/**
 * Class LocalizeCommandHandler
 */
final class LocalizeQueryHandler implements QueryHandlerInterface
{
    /**
     * LocalizeCommandHandler constructor.
     *
     * @param LocationRepositoryInterface $locationRepositoryInterface
     * @param VehicleRepositoryInterface  $vehicleRepositoryInterface
     */
    public function __construct(
        private readonly LocationRepositoryInterface $locationRepositoryInterface,
        private readonly VehicleRepositoryInterface $vehicleRepositoryInterface
    ) {
    }

    /**
     * @param LocalizeQuery $localizeQuery
     *
     * @return Location
     */
    public function __invoke(LocalizeQuery $localizeQuery): Location
    {
        $vehicle = $this->vehicleRepositoryInterface->findOneBy(
            ['vehiclePlateNumber' => $localizeQuery->getVehiclePlateNumber()]
        );
        if (null === $vehicle) {
            throw new \InvalidArgumentException(
                sprintf('Vehicle %s does not exist', $localizeQuery->getVehiclePlateNumber())
            );
        }

        $location = $this->locationRepositoryInterface->findOneBy([
            'fleet' => $localizeQuery->getFleetId(),
            'vehicle' => $vehicle->getId(),
        ]);
        if (null === $location) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Vehicle %s does not exist into fleet %d',
                    $vehicle->getVehiclePlateNumber(),
                    $localizeQuery->getFleetId()
                )
            );
        }
        if (null === $location->getLat() || null === $location->getLng()) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Vehicle %s not yet parked into fleet %d',
                    $vehicle->getVehiclePlateNumber(),
                    $localizeQuery->getFleetId()
                )
            );
        }

        return $location;
    }
}
