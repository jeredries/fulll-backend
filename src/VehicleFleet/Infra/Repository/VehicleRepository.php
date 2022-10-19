<?php

namespace App\VehicleFleet\Infra\Repository;

use App\VehicleFleet\Domain\Entity\Vehicle;
use App\VehicleFleet\Domain\Repository\VehicleRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class VehicleRepository
 *
 * @method Vehicle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicle[]    findAll()
 * @method Vehicle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleRepository extends ServiceEntityRepository implements VehicleRepositoryInterface
{
    /**
     * VehicleRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    /**
     * @param Vehicle $vehicle
     * @param bool    $needToFlush
     *
     * @return void
     */
    public function save(Vehicle $vehicle, bool $needToFlush = true): void
    {
        if (null === $vehicle->getId()) {
            $this->_em->persist($vehicle);
        }

        if ($needToFlush) {
            $this->_em->flush();
        }
    }
}
