<?php

namespace App\DataFixtures;

use App\Entity\Etudiant;
use App\Entity\Section;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EtudiantFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker=Factory::create('fr_FR');
        for($i=0;$i<22;$i++){
            $etudiant=new Etudiant();
            $etudiant->setNom($faker->firstName);
            $etudiant->setPrenom($faker->lastName);
            $etudiant->setSection(null);

            $manager->persist($etudiant);
            }
        $manager->flush();
        for ($i=0;$i<10;$i++)
        {$section = new Section();
            $section->setDesignation('Section'.$i);
            $manager->persist($section);}

        $manager->flush();
    }


}
