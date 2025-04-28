<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Livres;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class LivresFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($j = 1; $j <= 5; $j++) {
            $cat=new Categories();
            $names=['Roman','Intelligence Artificielle','Base de données', 'Cuisine', 'Histoire'];
            $cat->setLibelle($names[$j-1])
                ->setSlug(strtolower(str_replace(' ', '-', $names[$j-1])))
                ->setDescription($faker->text);
            $manager->persist($cat);

          for ($i = 1; $i < random_int(10,15); $i++) {
                $livre = new Livres();
                $titre = $faker->name();
                $livre->setTitre($titre)
                    ->setSlug(strtolower(str_replace(' ', '-', $titre)))
                    ->setIsbn($faker->isbn13())
                    ->setResume($faker->text)
                    ->setEditeur($faker->company())
                    ->setDateEdition($faker->dateTimeBetween('-5 year', 'now'))
                    ->setImage("https://picsum.photos/300/?id=" . $i)
                    ->setPrix($faker->randomFloat(2, 10, 700))
                    ->setCategorie($cat);

                $manager->persist($livre);
            }
        }
            $manager->flush();
        }

}