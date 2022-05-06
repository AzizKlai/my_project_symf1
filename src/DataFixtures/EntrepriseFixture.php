<?php

namespace App\DataFixtures;

use App\Entity\Entreprise;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EntrepriseFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {$names=[
        "ADD","foot","basket","guitar"
    ];
        $domaines=[
            "dvp","sport","ball","music"
        ];
        for ($i=0;$i<count($names);$i++)
    {$entreprise = new Entreprise();
        $entreprise->setName($names[$i]);
        $entreprise->setDomain($domaines[$i]);

        $manager->persist($entreprise);}

        $manager->flush();
    }
}
