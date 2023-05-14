<?php

namespace App\RequestDTO;

use App\Validation\Constraint\NotEmpty;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class TeamDTO extends BaseDTO {

    #[NotEmpty(message: 'Name not provided')]
    #[Assert\NotNull(message: 'Name not provided')]
    private ?string $name;

    #[NotEmpty(message: 'Country not provided')]
    #[Assert\NotNull(message: 'Country not provided')]
    private ?string $country;

    #[Assert\NotBlank(message: 'Balance not provided')]
    #[Assert\NotNull(message: 'Balance not provided')]
    #[Assert\GreaterThanOrEqual(value: 0, message: 'Balance cannot be less than 0')]
    private ?float $balance;

    #[Assert\All(
        new Assert\Collection(
            fields: [
                        'name'    => [
                            new Assert\Required,
                            new NotEmpty(message: 'Name not provided'),
                            new Assert\NotNull(message: 'Name cannot be null'),
                        ],
                        'surname' => [
                            new Assert\Required,
                            new NotEmpty(message: 'Surname not provided'),
                            new Assert\NotNull(message: 'Surname cannot be null'),
                        ],
                    ]
        )
    )]
    private ?array $players;

    public function __construct(Request $request) {

        $this->requestBody = $request->request->all();
        $this->name = $this->get('name');
        $this->country = $this->get('country');
        $this->balance = $this->get('balance');
        $this->players = $this->get('players') ?? [];
    }

    public function getName()
    : string {

        return $this->name;
    }

    public function getCountry()
    : string {

        return $this->country;
    }

    public function getBalance()
    : float {

        return $this->balance;
    }

    public function getPlayers()
    : array {

        return $this->players;
    }
}