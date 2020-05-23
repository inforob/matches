<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Match
{
    private const MATCH_STATUS_SCHEDULED  = '1' ;
    private const MATCH_STATUS_POSTPONED  = '2' ;
    private const MATCH_STATUS_DISPUTING  = '3' ;
    private const MATCH_STATUS_FINALIZED  = '4' ;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $season;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=Score::class, mappedBy="game")
     */
    private $score;

    /**
     * @ORM\OneToMany(targetEntity=Cards::class, mappedBy="game")
     */
    private $card;

    public function __construct()
    {
        $this->score = new ArrayCollection();
        $this->card = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getSeason(): ?string
    {
        return $this->season;
    }

    public function setSeason(string $season): self
    {
        $this->season = $season;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Score[]
     */
    public function getScore(): Collection
    {
        return $this->score;
    }

    public function addScore(Score $score): self
    {
        if (!$this->score->contains($score)) {
            $this->score[] = $score;
            $score->setGame($this);
        }

        return $this;
    }

    public function removeScore(Score $score): self
    {
        if ($this->score->contains($score)) {
            $this->score->removeElement($score);
            // set the owning side to null (unless already changed)
            if ($score->getGame() === $this) {
                $score->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Cards[]
     */
    public function getCard(): Collection
    {
        return $this->card;
    }

    public function addCard(Cards $card): self
    {
        if (!$this->card->contains($card)) {
            $this->card[] = $card;
            $card->setGame($this);
        }

        return $this;
    }

    public function removeCard(Cards $card): self
    {
        if ($this->card->contains($card)) {
            $this->card->removeElement($card);
            // set the owning side to null (unless already changed)
            if ($card->getGame() === $this) {
                $card->setGame(null);
            }
        }

        return $this;
    }
}
