<?php

namespace App\Service;

use App\Entity\Player;
use App\Entity\Team;
use App\Interfaces\Repository\CountryRepositoryInterface;
use App\Interfaces\Repository\TeamRepositoryInterface;
use App\Interfaces\Service\TeamServiceInterface;
use App\RequestDTO\TeamDTO;
use Doctrine\ORM\EntityManagerInterface;

class TeamService implements TeamServiceInterface {

    public function __construct(
        private readonly CountryRepositoryInterface $countryRepository,
        private readonly EntityManagerInterface     $entityManager,
        private readonly TeamRepositoryInterface    $teamRepository
    ) {
    }

    public function getTeams(int $page)
    : array {

        return [
            'teams' => $this->teamRepository->getTeamsForPage($page),
        ];
    }

    public function getDataForAddingTeam()
    : array {

        return [
            'countries' => $this->countryRepository->getAllCountries(),
        ];
    }

    public function addTeam(TeamDTO $dto)
    : void {

        $country = $this->countryRepository->getCountry($dto->getCountry());
        $team = new Team($dto->getName(), $country, $dto->getBalance());
        $players = $dto->getPlayers();

        foreach ($players as $playerInput) {
            $player = new Player($playerInput['name'], $playerInput['surname'], $team);
            $this->entityManager->persist($player);
        }

        $this->entityManager->persist($team);
        $this->entityManager->flush();
    }
}