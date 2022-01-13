<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Stage;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $stagePoterie = new Stage();
        $stagePoterie->setTitre("Stage de Poterie");
        $stagePoterie->setDescription("Vous allez faire de la poterie en somme");
        $stagePoterie->setEmailContact("super.poterie@gmail.com");
        $manager->persist($stagePoterie);

        $manager->flush();
    }
}
