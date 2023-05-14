<?php

namespace App\Interfaces\Service;

use App\RequestDTO\TeamDTO;

interface TeamServiceInterface {

    public function addTeam(TeamDTO $dto)
    : void;
}