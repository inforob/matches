<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CardsRepository")
 * @ORM\Table(name="cards")
 */
class Cards
{
    const CARD_TYPE_RED     = 'tarjeta-roja';
    const CARD_TYPE_YELLOW  = 'tarjeta-amarilla';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $minute;

    /**
     * @ORM\Column(type="smallint")
     */
    private $second;

    /**
     * @ORM\Column(type="string", columnDefinition="CHAR(1) NOT NULL")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Player::class, inversedBy="Cards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    /**
     * @ORM\ManyToOne(targetEntity=Match::class, inversedBy="Cards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMinute(): ?int
    {
        return $this->minute;
    }

    public function setMinute(int $minute): self
    {
        $this->minute = $minute;

        return $this;
    }

    public function getSecond(): ?int
    {
        return $this->second;
    }

    public function setSecond(int $second): self
    {
        $this->second = $second;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getGame(): ?Match
    {
        return $this->game;
    }

    public function setGame(?Match $game): self
    {
        $this->game = $game;

        return $this;
    }
}
