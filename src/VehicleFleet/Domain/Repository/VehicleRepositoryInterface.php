<?php

namespace App\VehicleFleet\Domain\Repository;

use App\VehicleFleet\Domain\Entity\Vehicle;

/**
 * interface VehicleRepositoryInterface
 */
interface VehicleRepositoryInterface
{
    /**
     * @param Vehicle $vehicle
     * @param bool    $needToFlush
     *
     * @return void
     */
    public function save(Vehicle $vehicle, bool $needToFlush = true): void;

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     *
     * @return Vehicle|null
     */
    public function findOneBy(array $criteria, array $orderBy = null);
}
