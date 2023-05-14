<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Country $country;

    #[ORM\Column]
    private float $balance;

    #[ORM\OneToMany(mappedBy: 'team', targetEntity: Player::class)]
    private Collection $players;

    #[ORM\Column]
    private string $publicId;

    public function __construct(string $name, Country $country, float $balance) {

        $this->name = $name;
        $this->country = $country;
        $this->setBalance($balance);
        $this->publicId = Uuid::v4();
        $this->players = new ArrayCollection();
    }

    public function getId()
    : ?int {

        return $this->id;
    }

    public function getName()
    : string {

        return $this->name;
    }

    public function getPlayers()
    : Collection {

        return $this->players;
    }

    public function getBalance()
    : float {

        return $this->balance;
    }

    public function setBalance(float $balance)
    : void {

        $this->balance = round($balance, 2);
    }

    public function getCountry()
    : Country {

        return $this->country;
    }

    public function getPublicId()
    : string {

        return $this->publicId;
    }

    public function canFundTransfer(float $amount)
    : bool {

        return $this->balance > $amount;
    }

    public function credit(float $amount)
    : void {

        $this->setBalance($this->balance + $amount);
    }

    public function debit(float $amount)
    : void {

        $this->setBalance($this->balance - $amount);
    }
}
