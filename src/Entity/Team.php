<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 * @ORM\Table(name="teams")
 */
class Team extends EntityBase
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $web;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $founded;

    /**
     * @ORM\OneToMany(targetEntity=Player::class, mappedBy="team")
     */
    private $players;

    /**
     * @ORM\OneToOne(targetEntity=Match::class, mappedBy="home", cascade={"persist", "remove"})
     */
    private $home;

    /**
     * @ORM\OneToOne(targetEntity=Match::class, mappedBy="away", cascade={"persist", "remove"})
     */
    private $away;

    public function __construct()
    {
        $this->players = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getWeb(): ?string
    {
        return $this->web;
    }

    public function setWeb(string $web): self
    {
        $this->web = $web;

        return $this;
    }

    public function getFounded(): ?string
    {
        return $this->founded;
    }

    public function setFounded(string $founded): self
    {
        $this->founded = $founded;

        return $this;
    }

    /**
     * @return Collection|Player[]
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players[] = $player;
            $player->setTeam($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->contains($player)) {
            $this->players->removeElement($player);
            // set the owning side to null (unless already changed)
            if ($player->getTeam() === $this) {
                $player->setTeam(null);
            }
        }

        return $this;
    }

}
