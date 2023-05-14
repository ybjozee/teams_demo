<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255)]
    private string $surname;

    #[ORM\ManyToOne(inversedBy: 'players')]
    #[ORM\JoinColumn(nullable: false)]
    private Team $team;

    #[ORM\Column]
    private string $publicId;

    public function __construct(string $name, string $surname, Team $team) {

        $this->name = $name;
        $this->surname = $surname;
        $this->team = $team;
        $this->publicId = Uuid::v4();
    }

    public function getId()
    : ?int {

        return $this->id;
    }

    public function getName()
    : string {

        return $this->name;
    }

    public function getSurname()
    : string {

        return $this->surname;
    }

    public function getTeam()
    : Team {

        return $this->team;
    }

    public function setTeam(Team $team)
    : void {

        $this->team = $team;
    }

    public function getPublicId()
    : string {

        return $this->publicId;
    }

    public function getFullName()
    : string {

        return "{$this->name} {$this->surname}";
    }

    public function canJoinTeam(Team $team)
    : bool {

        return $this->team !== $team;
    }
}
