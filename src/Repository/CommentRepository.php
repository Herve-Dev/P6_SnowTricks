<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 *
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function save(Comment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Comment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findCommentsPaginated(int $page, int $id_tricks, int $limit = 1): array
    {
        $limit = abs($limit);

        $result = [];


        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('comment')
            ->from('App\Entity\Comment', 'comment')
            ->where("comment.tricks = :tricks_id")
            ->setParameter('tricks_id', $id_tricks)
            ->setMaxResults($limit)
            ->setFirstResult(($page * $limit) - $limit);


            $paginator = new Paginator($query);
            $data = $paginator->getQuery()->getResult();

            //On vérifie qu'on a des données
            if (empty($data)) {
                return $result;
            }

            // On calcule le nombre de page
            $pages = ceil($paginator->count() / $limit);

            //On remplit le tableau
            $result['data'] = $data;
            $result['pages'] = $pages;
            $result['page'] = $page;
            $result['limit'] = $limit;

        return $result;
    }

//    /**
//     * @return Comment[] Returns an array of Comment objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Comment
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
