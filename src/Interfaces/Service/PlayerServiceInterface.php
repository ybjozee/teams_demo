<?php

namespace App\Interfaces\Service;

use App\RequestDTO\PlayerDTO;

interface PlayerServiceInterface {

    public function getPlayers(int $page)
    : array;

    public function getDataForAddingPlayer()
    : array;

    public function addPlayer(PlayerDTO $dto)
    : void;
}