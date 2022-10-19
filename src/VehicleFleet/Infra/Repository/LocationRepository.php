<?php

namespace App\VehicleFleet\Infra\Repository;

use App\VehicleFleet\Domain\Entity\Location;
use App\VehicleFleet\Domain\Repository\LocationRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class LocationRepository
 *
 * @method Location|null find($id, $lockMode = null, $lockVersion = null)
 * @method Location|null findOneBy(array $criteria, array $orderBy = null)
 * @method Location[]    findAll()
 * @method array         findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationRepository extends ServiceEntityRepository implements LocationRepositoryInterface
{
    /**
     * LocationRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    /**
     * @param Location $location
     * @param bool     $needToFlush
     *
     * @return void
     */
    public function save(Location $location, bool $needToFlush = true): void
    {
        if (null === $location->getId()) {
            $this->_em->persist($location);
        }

        if ($needToFlush) {
            $this->_em->flush();
        }
    }
}
