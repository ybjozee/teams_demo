<?php

namespace App\Entity;

use App\Enum\SaleStatus;
use App\Repository\SaleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: SaleRepository::class)]
class Sale {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Player::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private Player $player;

    #[ORM\ManyToOne(targetEntity: Team::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private Team $buyer;

    #[ORM\ManyToOne(targetEntity: Team::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private Team $seller;

    #[ORM\Column]
    private float $amount;

    #[ORM\Column(enumType: SaleStatus::class)]
    private SaleStatus $status;

    #[ORM\Column]
    private string $publicId;

    public function __construct(Player $player, Team $buyer, Team $seller, float $amount) {

        $this->player = $player;
        $this->buyer = $buyer;
        $this->seller = $seller;
        $this->amount = $amount;
        $this->status = SaleStatus::PENDING;
        $this->publicId = Uuid::v4();
    }

    public function getId()
    : ?int {

        return $this->id;
    }

    public function getPlayer()
    : Player {

        return $this->player;
    }

    public function getBuyer()
    : Team {

        return $this->buyer;
    }

    public function getSeller()
    : Team {

        return $this->seller;
    }

    public function getAmount()
    : float {

        return $this->amount;
    }

    public function getStatus()
    : SaleStatus {

        return $this->status;
    }

    public function getPublicId()
    : string {

        return $this->publicId;
    }

    public function complete(SaleStatus $status)
    : void {

        $this->status = $status;
        if (SaleStatus::isApproved($status)) {
            $this->seller->credit($this->amount);
            $this->buyer->debit($this->amount);
            $this->player->setTeam($this->buyer);
        }
    }

    public function isCompleted()
    : bool {

        return SaleStatus::isCompleted($this->status);
    }
}
