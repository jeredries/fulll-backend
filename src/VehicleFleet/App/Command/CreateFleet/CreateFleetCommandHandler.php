<?php

namespace App\VehicleFleet\App\Command\CreateFleet;

use App\Shared\Domain\Bus\Command\CommandHandlerInterface;
use App\VehicleFleet\Domain\Entity\Fleet;
use App\VehicleFleet\Domain\Repository\FleetRepositoryInterface;

/**
 * Class CreateFleetCommandHandler
 */
final class CreateFleetCommandHandler implements CommandHandlerInterface
{
    /**
     * CreateFleetCommandHandler constructor.
     *
     * @param FleetRepositoryInterface $fleetRepositoryInterface
     */
    public function __construct(private readonly FleetRepositoryInterface $fleetRepositoryInterface)
    {
    }

    /**
     * @param CreateFleetCommand $createVehicleCommand
     *
     * @return void
     */
    public function __invoke(CreateFleetCommand $createVehicleCommand): void
    {
        $userId = $createVehicleCommand->getUserId();
        if (null !== $this->fleetRepositoryInterface->find($userId)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Fleet with userId %d already exist',
                    $userId
                )
            );
        }
        $fleet = new Fleet();
        $fleet->setUserId($userId);

        $this->fleetRepositoryInterface->save($fleet);
    }
}
