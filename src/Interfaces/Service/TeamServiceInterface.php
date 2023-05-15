<?php

namespace App\Interfaces\Service;

use App\RequestDTO\TeamDTO;

interface TeamServiceInterface {

    public function getTeams(int $page)
    : array;

    public function getDataForAddingTeam()
    : array;

    public function addTeam(TeamDTO $dto)
    : void;
}