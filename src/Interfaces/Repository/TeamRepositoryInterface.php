<?php

namespace App\Interfaces\Repository;

use App\Entity\Team;
use App\Pagination\Paginator;

interface TeamRepositoryInterface {

    public function getTeamsForPage(int $page = 1)
    : Paginator;

    public function getTeam(string $publicId)
    : Team;

    public function getAllTeams()
    : array;
}