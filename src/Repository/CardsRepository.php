<?php

namespace App\Repository;

use App\Entity\Cards;
use App\Entity\Match;
use App\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cards|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cards|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cards[]    findAll()
 * @method Cards[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cards::class);
    }

    // /**
    //  * @return Cards[] Returns an array of Cards objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cards
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function save($data) : void
    {
        /** @var Cards $cards */
        if(isset($data['home']['cards'])){
            $this->storeCards($data['id'],$data['home']['cards']);
        }

        if(isset($data['away']['cards'])){
            $this->storeCards($data['id'],$data['away']['cards']);
        }
    }

    public function storeCards($idMatch,array $cards) {

        foreach ($cards as $card) {

            if($card['type'] != Cards::CARD_TYPE_RED && $card['type'] != Cards::CARD_TYPE_YELLOW){
                throw new \Exception('this colour card is not allowed');
            }

            /** @var Match $match */
            $match = $this->getEntityManager()
                ->getRepository(Match::class)->findOneBy(['id'=>$idMatch]);
            if(!$match) {
                throw new \Exception('This match is not registered for this season' );
            }

            /** @var Player $player */
            $player = $this->getEntityManager()
                ->getRepository(Player::class)->findOneBy(['id'=>$card['player']['id']]);
            if(!$player) {
                throw new \Exception('This player is not registered for this match:' . $card['player']['id']);
            }

            $fault = new Cards();

            $fault->setPlayer($player);
            $fault->setGame($match);
            $fault->setMinute($card['minute']);
            $fault->setSecond($card['second']);

            if($card['type'] === 'tarjeta-amarilla') {
                $fault->setType('1');
            } else if($card['type'] === 'tarjeta-roja') {
                $fault->setType('2');
            }

            $this->getEntityManager()->persist($fault);
            $this->getEntityManager()->flush();
        }
    }
}
