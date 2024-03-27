<?php

namespace OHMedia\MetaBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use OHMedia\MetaBundle\Entity\Meta;

/**
 * @method Meta|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meta|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meta[]    findAll()
 * @method Meta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MetaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Meta::class);
    }

    public function save(Meta $meta, bool $flush = false): void
    {
        $this->getEntityManager()->persist($meta);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Meta $meta, bool $flush = false): void
    {
        $this->getEntityManager()->remove($meta);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
