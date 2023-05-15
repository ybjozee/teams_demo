<?php

namespace App\Service;

use App\Entity\Player;
use App\Interfaces\Repository\PlayerRepositoryInterface;
use App\Interfaces\Repository\TeamRepositoryInterface;
use App\Interfaces\Service\PlayerServiceInterface;
use App\RequestDTO\PlayerDTO;

class PlayerService implements PlayerServiceInterface {

    public function __construct(
        private readonly TeamRepositoryInterface   $teamRepository,
        private readonly PlayerRepositoryInterface $playerRepository
    ) {
    }

    public function addPlayer(PlayerDTO $dto)
    : void {

        $team = $this->teamRepository->getTeam($dto->getTeam());
        $player = new Player($dto->getName(), $dto->getSurname(), $team);
        $this->playerRepository->save($player, true);
    }

    public function getPlayers(int $page)
    : array {

        return [
            'players' => $this->playerRepository->getPlayersForPage($page),
        ];
    }

    public function getDataForAddingPlayer()
    : array {

        return [
            'teams' => $this->teamRepository->getAllTeams(),
        ];
    }
}