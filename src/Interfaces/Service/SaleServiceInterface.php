<?php

namespace App\Interfaces\Service;

use App\Exception\ExtraValidationException;
use App\RequestDTO\SaleDTO;

interface SaleServiceInterface {

    /**
     * @throws ExtraValidationException
     */
    public function initiateSale(SaleDTO $dto)
    : void;

    public function completeSale(string $publicId, string $status)
    : array;
}