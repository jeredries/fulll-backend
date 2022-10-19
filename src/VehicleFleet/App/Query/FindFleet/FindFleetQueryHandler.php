<?php

namespace App\VehicleFleet\App\Query\FindFleet;

use App\Shared\Domain\Bus\Query\QueryHandlerInterface;
use App\VehicleFleet\Domain\Entity\Fleet;
use App\VehicleFleet\Domain\Repository\FleetRepositoryInterface;

/**
 * Class FindFleetQueryHandler
 */
final class FindFleetQueryHandler implements QueryHandlerInterface
{
    /**
     * FindFleetQueryHandler constructor.
     *
     * @param FleetRepositoryInterface $fleetRepositoryInterface
     */
    public function __construct(private readonly FleetRepositoryInterface $fleetRepositoryInterface)
    {
    }

    /**
     * @param FindFleetQuery $findFleetQuery
     *
     * @return Fleet
     */
    public function __invoke(FindFleetQuery $findFleetQuery): Fleet
    {
        $fleet = $this->fleetRepositoryInterface->find($findFleetQuery->getUserId());
        if (null === $fleet) {
            throw new \InvalidArgumentException(
                sprintf('Fleet with userId %d does not exist', $findFleetQuery->getUserId())
            );
        }

        return $fleet;
    }
}
