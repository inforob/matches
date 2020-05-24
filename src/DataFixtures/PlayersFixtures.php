<?php
// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Entity\Player;
use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class PlayersFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $team = new Team();
        $team->setName('Valencia');
        $team->setCountry('ESP');
        $team->setFounded('1998');
        $team->setWeb('http://valencia-fc');
        $manager->persist($team);
        $manager->flush();

        /** @var Player $player */
        for ($i = 0; $i < 20; $i++) {
            $player = new Player();
            $player->setName('player-'. $i);
            $player->setTeam($team);
            $player->setPosition('delantero');
            $player->setWeight(50);
            $player->setHeight(150);
            $player->setInternational(false);
            $player->setBirthday(new \DateTime());
            $manager->persist($player);
        }

        $manager->flush();
    }
}
