<?php

namespace App\Interfaces\Repository;

use App\Entity\Sale;
use App\Pagination\Paginator;

interface SaleRepositoryInterface {

    public function save(Sale $entity, bool $flush = false)
    : void;

    public function getSalesForPage(int $page = 1)
    : Paginator;

    public function getSale(string $publicId)
    : Sale;
}