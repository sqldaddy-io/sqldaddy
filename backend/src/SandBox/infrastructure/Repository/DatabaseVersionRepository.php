<?php

namespace App\SandBox\infrastructure\Repository;

use App\SandBox\Domain\Entity\DatabaseVersion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DatabaseVersion>
 *
 * @method DatabaseVersion|null find($id, $lockMode = null, $lockVersion = null)
 * @method DatabaseVersion|null findOneBy(array $criteria, array $orderBy = null)
 * @method DatabaseVersion[]    findAll()
 * @method DatabaseVersion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DatabaseVersionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DatabaseVersion::class);
    }

    public function save(DatabaseVersion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DatabaseVersion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DatabaseVersion[] Returns an array of DatabaseVersion objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DatabaseVersion
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
