<?php

namespace App\SandBox\infrastructure\Repository;

use App\SandBox\Domain\Entity\DatabaseParam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DatabaseParam>
 *
 * @method DatabaseParam|null find($id, $lockMode = null, $lockVersion = null)
 * @method DatabaseParam|null findOneBy(array $criteria, array $orderBy = null)
 * @method DatabaseParam[]    findAll()
 * @method DatabaseParam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DatabaseParamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DatabaseParam::class);
    }

    public function save(DatabaseParam $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DatabaseParam $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DatabaseParam[] Returns an array of DatabaseParam objects
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

//    public function findOneBySomeField($value): ?DatabaseParam
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
