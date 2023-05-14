<?php

namespace App\DataFixtures;

use App\Entity\Player;
use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class TeamsFixtures extends Fixture implements DependentFixtureInterface {

    private Generator $faker;

    public function __construct() {

        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    : void {

        $teamNames = ['LA Galaxy', 'Miami FC'];
        foreach ($teamNames as $teamName) {
            $team = new Team(
                $teamName,
                $this->getReference(CountryFixtures::REFERENCE),
                $this->faker->randomFloat(2, 5000000)
            );
            $this->addPlayers($team, $manager);
            $manager->persist($team);
        }

        $manager->flush();
    }

    private function addPlayers(Team $team, ObjectManager $manager)
    : void {

        for ($i = 0; $i < 21; $i++) {
            $manager->persist(new Player($this->faker->firstName(), $this->faker->lastName(), $team));
        }
    }

    public function getDependencies()
    : array {

        return [CountryFixtures::class];
    }
}
