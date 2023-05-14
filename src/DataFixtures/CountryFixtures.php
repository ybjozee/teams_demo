<?php

namespace App\DataFixtures;

use App\Entity\Country;
use App\Traits\CanReadJSONFIle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use JsonException;

class CountryFixtures extends Fixture {

    use CanReadJSONFIle;

    public const REFERENCE = 'COUNTRY_FIXTURE_REFERENCE';

    /**
     * @throws JsonException
     */
    public function load(ObjectManager $manager)
    : void {

        $countryNames = $this->readJSONFile('Constants/countries.json');

        $referenceCountryName = $countryNames[0];
        $referenceCountry = new Country($referenceCountryName);
        $this->addReference(self::REFERENCE, $referenceCountry);
        $manager->persist($referenceCountry);

        for ($i = 1; $i < count($countryNames); $i++) {
            $manager->persist(new Country($countryNames[$i]));
        }

        $manager->flush();
    }
}
