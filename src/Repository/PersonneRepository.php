<?php

namespace App\Repository;

use App\Entity\Personne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use \Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Personne>
 *
 * @method Personne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personne[]    findAll()
 * @method Personne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personne::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Personne $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Personne $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Personne[] Returns an array of Personne objects
    //  */

    public function getPersonneByAge($ageMin,$ageMax)
    {
        $qb=$this->createQueryBuilder('p');
            $qb = $this->fingByAgeInterval($qb, $ageMin, $ageMax);
            return $qb->orderBy('p.age', 'ASC')
//            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    public function getStatPersonneByAge($ageMin,$ageMax)
    {
        $qb=$this->createQueryBuilder('p');
        $qb->select('COUNT(p.age) as nbPersonne, AVG(p.age) as avgUserAge');
        $qb = $this->fingByAgeInterval($qb, $ageMin, $ageMax);
        return $qb->orderBy('p.age', 'ASC')
//            ->setMaxResults(10)
            ->getQuery()
            ->getScalarResult()
            ;
    }
    private function fingByAgeInterval(QueryBuilder $qb,$ageMin,$ageMax){
        if($ageMin) {
            $qb->andWhere('p.age > :ageMin')
                ->setParameter('ageMin', $ageMin);
        }
        if($ageMax) {
            $qb->andWhere('p.age < :ageMax')
                ->setParameter('ageMax', $ageMax);
        }
        return $qb;
    }


    /*
    public function findOneBySomeField($value): ?Personne
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
