<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfileFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {  $profile=new Profile();
        $profile->setEmail('azizklai24@gmail.com');
        $profile->setFacebook('https://www.facebook.com');
        $profile->setGithub('https://www.github.com');
        $profile1=new Profile();
        $profile1->setEmail('mohamedaziz.klai@insat.ucar.tn');
        $profile1->setFacebook('https://www.facebook.com');
        $profile1->setGithub('https://www.github.com');

        // $product = new Product();
        $manager->persist($profile);
        $manager->persist($profile1);

        $manager->flush();
    }
}
