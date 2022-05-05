<?php

namespace App\DataFixtures;

use App\Entity\Personne;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PersonneFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {  $faker=Factory::create('fr_FR');
        for($i=0;$i<22;$i++){
        $personne1=new Personne();
        $personne1->setFirstname($faker->firstName);
        $personne1->setName($faker->lastName);
        $personne1->setAge($faker->numberBetween(18,50));

        // $product = new Product();
        $manager->persist($personne1);
        $manager->flush();}
    }
}
