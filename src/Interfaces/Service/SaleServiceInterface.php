<?php

namespace App\Interfaces\Service;

use App\Exception\ExtraValidationException;
use App\RequestDTO\SaleDTO;

interface SaleServiceInterface {

    public function getSales(int $page)
    : array;

    public function getDataForInitiatingSale()
    : array;

    /**
     * @throws ExtraValidationException
     */
    public function initiateSale(SaleDTO $dto)
    : void;

    public function completeSale(string $publicId, string $status)
    : array;
}