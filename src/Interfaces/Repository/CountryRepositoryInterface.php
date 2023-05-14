<?php

namespace App\Interfaces\Repository;

use App\Entity\Country;

interface CountryRepositoryInterface {

    public function getAllCountries()
    : array;

    public function getCountry(string $id)
    : Country;
}