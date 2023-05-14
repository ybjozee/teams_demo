<?php

namespace App\Controller;

use App\Interfaces\Repository\CountryRepositoryInterface;
use App\Interfaces\Repository\TeamRepositoryInterface;
use App\Interfaces\Service\TeamServiceInterface;
use App\RequestDTO\TeamDTO;
use App\Validation\DTOValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/teams', name: 'app_team_')]
class TeamController extends AbstractController {

    #[Route('', name: 'index')]
    public function index(Request $request, TeamRepositoryInterface $teamRepository)
    : Response {

        $page = $request->query->get('page') ?? 1;

        return $this->render('team/index.html.twig', [
            'teams' => $teamRepository->getTeamsForPage($page),
        ]);
    }

    #[Route('/add', name: 'add', methods: ['GET', 'POST'])]
    public function addTeam(
        Request                    $request,
        DTOValidator               $validator,
        CountryRepositoryInterface $countryRepository,
        TeamServiceInterface       $teamService,
        UrlGeneratorInterface      $urlGenerator
    )
    : Response {

        $errors = $values = [];
        if ($request->getMethod() === Request::METHOD_POST) {
            $dto = new TeamDTO($request);
            $errors = $validator->validate($dto);
            if (count($errors) == 0) {
                $teamService->addTeam($dto);

                return new RedirectResponse($urlGenerator->generate('app_team_index'));
            }
            $values = $request->request->all();
        }

        return $this->render(
            'team/new.html.twig',
            [
                'countries' => $countryRepository->getAllCountries(),
                'errors'    => $errors,
                'values'    => $values,
            ]
        );
    }
}
