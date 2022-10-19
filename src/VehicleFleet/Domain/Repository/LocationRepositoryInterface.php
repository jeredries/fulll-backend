<?php

namespace App\VehicleFleet\Domain\Repository;

use App\VehicleFleet\Domain\Entity\Location;

/**
 * interface LocationRepositoryInterface
 */
interface LocationRepositoryInterface
{
    /**
     * @param Location $location
     * @param bool     $needToFlush
     *
     * @return void
     */
    public function save(Location $location, bool $needToFlush = true): void;

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     *
     * @return Location|null
     */
    public function findOneBy(array $criteria, array $orderBy = null);
}
