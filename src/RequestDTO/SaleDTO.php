<?php

namespace App\RequestDTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class SaleDTO extends BaseDTO {

    #[Assert\NotBlank(message: 'Name not provided')]
    #[Assert\NotNull(message: 'Name not provided')]
    private ?string $player;

    #[Assert\NotBlank(message: 'Buyer not provided')]
    #[Assert\NotNull(message: 'Buyer not provided')]
    private ?string $buyer;

    #[Assert\NotBlank(message: 'Sale amount not provided')]
    #[Assert\NotNull(message: 'Sale amount not provided')]
    #[Assert\GreaterThanOrEqual(value: 0, message: 'Sale amount cannot be less than 0')]
    private ?float $amount;

    public function __construct(Request $request) {

        $this->requestBody = $request->request->all();
        $this->player = $this->get('player');
        $this->buyer = $this->get('buyer');
        $this->amount = $this->get('amount');
    }

    public function getPlayer()
    : string {

        return $this->player;
    }

    public function getBuyer()
    : string {

        return $this->buyer;
    }

    public function getAmount()
    : float {

        return $this->amount;
    }
}