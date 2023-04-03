<?php

namespace App\SandBox\infrastructure\Repository;

use App\SandBox\Domain\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Page>
 *
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }

    public function getEm(): \Doctrine\ORM\EntityManagerInterface
    {
        return $this->getEntityManager();

    }

    /**
     * @throws Exception
     */
    public function getStatistics(): array
    {
        $sql = "select d.id, d.name,
                     count(p.id) as all_time,
                         count(p.id) filter(WHERE p.create_at > current_date - interval '90' day)  as last_90_days,
                             count(p.id) filter(WHERE p.create_at > current_date - interval '7' day)  as last_7_days
                from page as p
                     left join database_version as dv on dv.id = p.database_version_id
                         right join database as d on d.id = dv.database_id
                group by d.id";

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);

        return $stmt->executeQuery()->fetchAllAssociative();
    }

    public function save(Page $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Page $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Page[] Returns an array of Page objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Page
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
