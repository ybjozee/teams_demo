<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function __construct(
        #[ORM\Column]
        private readonly string $name
    ) {
    }

    public function getId()
    : ?int {

        return $this->id;
    }

    public function getName()
    : ?string {

        return $this->name;
    }
}
