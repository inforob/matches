<?php

namespace App\Repository;

use App\Entity\EntityBase;
use App\Entity\Match;
use App\Entity\Team;
use App\Interfaces\EntityInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository implements EntityInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

    // /**
    //  * @return Team[] Returns an array of Team objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Team
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function save(array $data) : Team {
        $team = new Team();

        $team->setName($data['name']);
        $team->setWeb($data['url']);
        $team->setFounded('');
        $team->setCountry($data['country']);

        $this->getEntityManager()->persist($team);
        $this->getEntityManager()->flush();

        return $team;

    }

    public function update(EntityBase $entity, array $data): Team
    {

    }
}
