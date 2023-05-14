<?php

namespace App\RequestDTO;

use App\Validation\Constraint\NotEmpty;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class PlayerDTO extends BaseDTO {

    #[NotEmpty(message: 'Name not provided')]
    #[Assert\NotNull(message: 'Name not provided')]
    private ?string $name;

    #[NotEmpty(message: 'Name not provided')]
    #[Assert\NotNull(message: 'Name not provided')]
    private ?string $surname;

    #[Assert\NotBlank(message: 'Team not provided')]
    #[Assert\NotNull(message: 'Team not provided')]
    private ?string $team;

    public function __construct(Request $request) {

        $this->requestBody = $request->request->all();
        $this->name = $this->get('name');
        $this->surname = $this->get('surname');
        $this->team = $this->get('team');
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
    : string {

        return $this->team;
    }
}