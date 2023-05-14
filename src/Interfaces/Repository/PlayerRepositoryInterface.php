<?php

namespace App\Interfaces\Repository;

use App\Entity\Player;
use App\Pagination\Paginator;

interface PlayerRepositoryInterface {

    public function save(Player $entity, bool $flush = false)
    : void;

    public function getPlayersForPage(int $page = 1)
    : Paginator;

    public function getPlayer(string $publicId)
    : Player;

    public function getAllPlayers()
    : array;
}