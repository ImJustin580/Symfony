<?php

namespace App\Repository;

use App\Entity\Employe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Employe>
 */
class EmployeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employe::class);
    }

    public function findByFilters(?string $prenom, ?string $nom): array
    {
        $qb = $this->createQueryBuilder('e');
    
        if (!empty($prenom)) {
            $qb->andWhere('e.prenom LIKE :prenom')
               ->setParameter('prenom', '%' . $prenom . '%');
        }
        if (!empty($nom)) {
            $qb->andWhere('e.nom LIKE :nom')
               ->setParameter('nom', '%' . $nom . '%');
        }
    
        $qb->addOrderBy('e.nom', 'ASC')
           ->addOrderBy('e.prenom', 'ASC');
    
        return $qb->getQuery()->getResult();
    }
    //    /**
    //     * @return Employe[] Returns an array of Employe objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Employe
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
