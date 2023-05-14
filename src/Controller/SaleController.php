<?php

namespace App\Controller;

use App\Enum\SaleStatus;
use App\Exception\ExtraValidationException;
use App\Interfaces\Repository\PlayerRepositoryInterface;
use App\Interfaces\Repository\SaleRepositoryInterface;
use App\Interfaces\Repository\TeamRepositoryInterface;
use App\Interfaces\Service\SaleServiceInterface;
use App\RequestDTO\SaleDTO;
use App\Validation\DTOValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Requirement\EnumRequirement;

#[Route('/sales', name: 'app_sale_')]
class SaleController extends AbstractController {

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, SaleRepositoryInterface $saleRepository)
    : Response {

        $page = $request->query->get('page') ?? 1;

        return $this->render('sale/index.html.twig', [
            'sales' => $saleRepository->getSalesForPage($page),
        ]);
    }

    #[Route('/initiate', name: 'initiate', methods: ['GET', 'POST'])]
    public function initiateSale(
        Request                   $request,
        DTOValidator              $validator,
        PlayerRepositoryInterface $playerRepository,
        TeamRepositoryInterface   $teamRepository,
        SaleServiceInterface      $saleService,
        UrlGeneratorInterface     $urlGenerator
    )
    : Response {

        $errors = $values = [];
        $player = $request->query->get('player');
        if (!is_null($player) && $request->isMethod(Request::METHOD_GET)) {
            $values['player'] = $player;
        }
        if ($request->isMethod(Request::METHOD_POST)) {
            $dto = new SaleDTO($request);
            $errors = $validator->validate($dto);
            if (count($errors) == 0) {
                try {
                    $saleService->initiateSale($dto);

                    return new RedirectResponse($urlGenerator->generate('app_sale_index'));
                }
                catch (ExtraValidationException $exception) {
                    $errors['extra'] = $exception->getMessage();
                }
            }
            $values = $request->request->all();
        }

        return $this->render('sale/new.html.twig', [
            'teams'   => $teamRepository->getAllTeams(),
            'players' => $playerRepository->getAllPlayers(),
            'values'  => $values,
            'errors'  => $errors,
        ]);
    }

    #[Route('/complete/{publicId}/{status}',
        name: 'complete',
        requirements: [
            'status' => new EnumRequirement(
                [SaleStatus::APPROVED, SaleStatus::REJECTED]
            ),
        ],
        methods: ['GET'])
    ]
    public function completeSale(
        string                  $publicId,
        string                  $status,
        SaleServiceInterface    $saleService,
        SaleRepositoryInterface $saleRepository
    )
    : Response {

        return $this->render(
            'sale/index.html.twig',
            [
                'feedback' => $saleService->completeSale($publicId, $status),
                'sales'    => $saleRepository->getSalesForPage(1),
            ]
        );
    }
}
