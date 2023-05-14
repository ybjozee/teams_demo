<?php

namespace App\Service;

use App\Entity\Sale;
use App\Enum\SaleStatus;
use App\Exception\ExtraValidationException;
use App\Interfaces\Repository\PlayerRepositoryInterface;
use App\Interfaces\Repository\SaleRepositoryInterface;
use App\Interfaces\Repository\TeamRepositoryInterface;
use App\Interfaces\Service\SaleServiceInterface;
use App\RequestDTO\SaleDTO;

class SaleService implements SaleServiceInterface {

    public function __construct(
        private readonly PlayerRepositoryInterface $playerRepository,
        private readonly SaleRepositoryInterface   $saleRepository,
        private readonly TeamRepositoryInterface   $teamRepository
    ) {
    }

    public function initiateSale(SaleDTO $dto)
    : void {

        $player = $this->playerRepository->getPlayer($dto->getPlayer());
        $buyer = $this->teamRepository->getTeam($dto->getBuyer());
        $amount = $dto->getAmount();
        $seller = $player->getTeam();

        if (!$player->canJoinTeam($buyer)) {
            throw new ExtraValidationException("{$player->getFullName()} already belongs to {$buyer->getName()}");
        }
        if (!$buyer->canFundTransfer($amount)) {
            throw new ExtraValidationException('Insufficient funds to initiate this transfer');
        }

        $sale = new Sale($player, $buyer, $seller, $amount);
        $this->saleRepository->save($sale, true);
    }

    public function completeSale(string $publicId, string $status)
    : array {

        $sale = $this->saleRepository->getSale($publicId);
        $saleStatus = SaleStatus::from($status);
        $sale->complete($saleStatus);
        $this->saleRepository->save($sale, true);

        $message =
            "{$sale->getPlayer()->getFullName()}'s sale to {$sale->getBuyer()->getName()} was ".strtolower($status);

        return ['message' => $message, 'isApproved' => SaleStatus::isApproved($saleStatus)];
    }
}