<?php

namespace App\DataFixtures;

use App\Entity\Livres;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class LivresFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {  $faker = Factory::create('fr_FR');
        for ($i = 1; $i < 100; $i++) {
        $livre = new Livres();
        $titre = $faker->name();
        $livre->setTitre($titre)
            ->setSlug(strtolower(str_replace(' ','-',$titre)))
            ->setIsbn($faker->isbn13())
            ->setResume($faker->text)
                ->setEditeur($faker->company())
            ->setDateEdition($faker->dateTimeBetween('-5 year', 'now'))
            ->setImage("https://picsum.photos/300/?id=".$i)
            ->setPrix($faker->randomFloat(2,10,700));

        $manager->persist($livre);
    }
        $manager->flush();
    }
}
