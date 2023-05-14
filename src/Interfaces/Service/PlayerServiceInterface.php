<?php

namespace App\Interfaces\Service;

use App\RequestDTO\PlayerDTO;

interface PlayerServiceInterface {

    public function addPlayer(PlayerDTO $dto)
    : void;
}