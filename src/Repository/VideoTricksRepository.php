<?php

namespace App\Repository;

use App\Entity\VideoTricks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VideoTricks>
 *
 * @method VideoTricks|null find($id, $lockMode = null, $lockVersion = null)
 * @method VideoTricks|null findOneBy(array $criteria, array $orderBy = null)
 * @method VideoTricks[]    findAll()
 * @method VideoTricks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoTricksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideoTricks::class);
    }

    public function save(VideoTricks $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(VideoTricks $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return VideoTricks[] Returns an array of VideoTricks objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//    }

//    public function findOneBySomeField($value): ?VideoTricks
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//    }
}
