<?php

namespace App\VehicleFleet\Domain\Repository;

use App\VehicleFleet\Domain\Entity\Fleet;

/**
 * interface FleetRepositoryInterface
 */
interface FleetRepositoryInterface
{
    /**
     * @param Fleet $fleet
     * @param bool  $needToFlush
     *
     * @return void
     */
    public function save(Fleet $fleet, bool $needToFlush = true): void;

    /**
     * @param $id
     * @param $lockMode
     * @param $lockVersion
     *
     * @return Fleet|null
     */
    public function find($id, $lockMode = null, $lockVersion = null);
}
