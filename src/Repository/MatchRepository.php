<?php

namespace App\Repository;

use App\Entity\Cards;
use App\Entity\EntityBase;
use App\Entity\Match;
use App\Entity\Player;
use App\Entity\Score;
use App\Entity\Team;
use App\Interfaces\EntityInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Match|null find($id, $lockMode = null, $lockVersion = null)
 * @method Match|null findOneBy(array $criteria, array $orderBy = null)
 * @method Match[]    findAll()
 * @method Match[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchRepository extends ServiceEntityRepository implements EntityInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Match::class);
    }

    // /**
    //  * @return Match[] Returns an array of Match objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Match
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function save($data): Match
    {
        $match = new Match();
        $match->setId($data['id']);
        $match->setStatus($data['metadata']['status']);
        $match->setSeason($data['metadata']['season']);
        $match->setDate(new \DateTimeImmutable($data['metadata']['date']));

        $home = $this->getEntityManager()->getRepository(Team::class)
            ->findOneBy(['id' => $data['home']['id']]);
        if (!$home) {
            /** @var Team $home */
            $home = $this->getEntityManager()
                ->getRepository(Team::class)
                ->save($data['home']);
        }

        $away = $this->getEntityManager()->getRepository(Team::class)
            ->findOneBy(['id' => $data['away']['id']]);
        if (!$away) {
            /** @var Team $away */
            $away = $this->getEntityManager()
                ->getRepository(Team::class)
                ->save($data['away']);
        }
        $match->setHome($home);
        $match->setAway($away);

        $this->getEntityManager()->persist($match);
        $this->getEntityManager()->flush();

        return $match;
    }

    public function update(EntityBase $entity, array $data): Match
    {
        if( $entity instanceof Match ) {

            $entity->setStatus($data['metadata']['status']);

            $score = $this->getEntityManager()
                ->getRepository(Score::class)
                ->save($data);

            $cards = $this->getEntityManager()
                ->getRepository(Cards::class)
                ->save($data);
        }

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity;

    }

}
