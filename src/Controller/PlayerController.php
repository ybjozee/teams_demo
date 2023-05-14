<?php

namespace App\Controller;

use App\Interfaces\Repository\PlayerRepositoryInterface;
use App\Interfaces\Repository\TeamRepositoryInterface;
use App\Interfaces\Service\PlayerServiceInterface;
use App\RequestDTO\PlayerDTO;
use App\Validation\DTOValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/players', name: 'app_player_')]
class PlayerController extends AbstractController {

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, PlayerRepositoryInterface $playerRepository)
    : Response {

        $page = $request->query->get('page') ?? 1;

        return $this->render('player/index.html.twig', [
            'players' => $playerRepository->getPlayersForPage($page),
        ]);
    }

    #[Route('/add', name: 'add', methods: ['GET', 'POST'])]
    public function addPlayer(
        Request                 $request,
        DTOValidator            $validator,
        TeamRepositoryInterface $teamRepository,
        PlayerServiceInterface  $playerService,
        UrlGeneratorInterface   $urlGenerator
    )
    : Response {

        $errors = $values = [];
        if ($request->getMethod() === Request::METHOD_POST) {
            $dto = new PlayerDTO($request);
            $errors = $validator->validate($dto);
            if (count($errors) == 0) {
                $playerService->addPlayer($dto);

                return new RedirectResponse($urlGenerator->generate('app_player_index'));
            }
            $values = $request->request->all();
        }

        return $this->render('player/new.html.twig', [
            'teams'  => $teamRepository->getAllTeams(),
            'values' => $values,
            'errors' => $errors,
        ]);
    }
}
