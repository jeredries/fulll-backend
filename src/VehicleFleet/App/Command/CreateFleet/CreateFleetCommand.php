<?php

namespace App\VehicleFleet\App\Command\CreateFleet;

use App\Shared\Domain\Bus\Command\CommandInterface;

/**
 * Class CreateFleetCommand
 */
final class CreateFleetCommand implements CommandInterface
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
