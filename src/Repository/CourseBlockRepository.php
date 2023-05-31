<?php

namespace App\Repository;

use App\Entity\CourseBlock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CourseBlock>
 *
 * @method CourseBlock|null find($id, $lockMode = null, $lockVersion = null)
 * @method CourseBlock|null findOneBy(array $criteria, array $orderBy = null)
 * @method CourseBlock[]    findAll()
 * @method CourseBlock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseBlockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourseBlock::class);
    }

    public function save(CourseBlock $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CourseBlock $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllByCourseId(int $id)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT cb.id, cb.name, cb.description, cb.courseId
            FROM App\Entity\CourseBlock cb
            WHERE cb.courseId = :courseId'
        )->setParameter('courseId', $id);
        return $query->getResult();
    }

//    /**
//     * @return CourseBlock[] Returns an array of CourseBlock objects
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

//    public function findOneBySomeField($value): ?CourseBlock
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
