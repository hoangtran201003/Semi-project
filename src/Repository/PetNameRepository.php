<?php

namespace App\Repository;

use App\Entity\PetName;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PetName>
 *
 * @method PetName|null find($id, $lockMode = null, $lockVersion = null)
 * @method PetName|null findOneBy(array $criteria, array $orderBy = null)
 * @method PetName[]    findAll()
 * @method PetName[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PetNameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PetName::class);
    }

//    /**
//     * @return PetName[] Returns an array of PetName objects
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

//    public function findOneBySomeField($value): ?PetName
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
