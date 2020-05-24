<?php

namespace App\Repository;

use App\Entity\EntityBase;
use App\Entity\Match;
use App\Entity\Player;
use App\Entity\Score;
use App\Interfaces\EntityInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Runner\Exception;

/**
 * @method Score|null find($id, $lockMode = null, $lockVersion = null)
 * @method Score|null findOneBy(array $criteria, array $orderBy = null)
 * @method Score[]    findAll()
 * @method Score[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScoreRepository extends ServiceEntityRepository implements EntityInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Score::class);
    }

    // /**
    //  * @return Score[] Returns an array of Score objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getRes  public function save($data): Match
    {ult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Score
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function save($data) : void
    {
        /** @var Score $score */
        if(isset($data['home']['scorers'])){
            $this->storeGoals($data['id'],$data['home']['scorers']);
        }

        if(isset($data['away']['scorers'])){
            $this->storeGoals($data['id'],$data['away']['scorers']);
        }

    }

    public function update(EntityBase $entity, array $data): Score
    {}

    public function storeGoals($idMatch,array $scorers) {

        foreach ($scorers as $goals) {
            $score = new Score();

            /** @var Match $match */
            $match = $this->getEntityManager()
                ->getRepository(Match::class)->findOneBy(['id'=>$idMatch]);
            if(!$match) {
                throw new \Exception('This match is not registered for this season' );
            }

            /** @var Player $player */
            $player = $this->getEntityManager()
                ->getRepository(Player::class)->findOneBy(['id'=>$goals['player']['id']]);
            if(!$player) {
                throw new \Exception('This player is not registered for this match:' . $goals['player']['id']);
            }

            $score->setPlayer($player);
            $score->setGame($match);
            $score->setMinute($goals['minute']);
            $score->setSecond($goals['second']);

            $score->setCreatedAt(new \DateTime());
            $score->setUpdatedAt(new \DateTime());

            $this->getEntityManager()->persist($score);
            $this->getEntityManager()->flush();
        }
    }

}
