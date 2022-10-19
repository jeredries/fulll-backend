<?php

namespace App\VehicleFleet\App\Query\FindFleet;

use App\Shared\Domain\Bus\Query\QueryInterface;

/**
 * Class FindFleetQuery
 */
final class FindFleetQuery implements QueryInterface
{
    /**
     * CreateFleetCommand constructor.
     *
     * @param int $userId
     */
    public function __construct(private int $userId)
    {
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }
}
