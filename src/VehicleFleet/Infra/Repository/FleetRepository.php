<?php

namespace App\VehicleFleet\Infra\Repository;

use App\VehicleFleet\Domain\Entity\Fleet;
use App\VehicleFleet\Domain\Repository\FleetRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class FleetRepository
 *
 * @method Fleet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fleet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fleet[]    findAll()
 * @method Fleet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FleetRepository extends ServiceEntityRepository implements FleetRepositoryInterface
{
    /**
     * FleetRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fleet::class);
    }

    /**
     * @param Fleet $fleet
     * @param bool  $needToFlush
     *
     * @return void
     */
    public function save(Fleet $fleet, bool $needToFlush = true): void
    {
        if (null === $fleet->getId()) {
            $this->_em->persist($fleet);
        }

        if ($needToFlush) {
            $this->_em->flush();
        }
    }
}
