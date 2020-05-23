<?php
namespace App\Api\Action;


use App\Entity\Cards;
use App\Entity\Match;
use App\Entity\Player;
use App\Entity\Team;
use App\Events\SneakEvent;
use DateTime;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MatchController
{

    public function index(
        ManagerRegistry $managerRegistry,
        EventDispatcherInterface $dispatcher,
        Request $request,
        LoggerInterface $logger)
    {

        /** @var Match $match */
        $match = $managerRegistry
            ->getRepository(Match::class)
            ->findOneBy(['id'=>1]);

        /** @var Player $player */
        $player = $managerRegistry
            ->getRepository(Player::class)
            ->findOneBy(['id'=>1]);

        /** @var Team $team */
        $team = $managerRegistry
            ->getRepository(Team::class)
            ->findOneBy(['id'=>2]);

        /** @var Cards $cards */
        $cards = new Cards();
        $cards->setMinute(98);
        $cards->setPlayer($player);
        $cards->setSecond(56);
        $cards->setType(Cards::CARD_TYPE_YELLOW);
        $cards->setPlayer($player);
        $cards->setGame($match);

        $player->setTeam($team);
        $em = $managerRegistry->getManager();

        $em->persist($cards);
        $em->flush();


        if($request->getMethod() == 'GET') {
            return new JsonResponse(['msg'=>'this ok4']);
        } else if($request->getMethod() == 'POST') {
            $test = json_decode($request->getContent());

            $event = new SneakEvent();

            $dispatcher->dispatch($event,'sneak.event');

            return new JsonResponse(['msg'=>'this ok2','parameters'=>$test]);
        }


    }

}
