<?php

namespace App\DataFixtures;

use App\Entity\Evenement;
use App\Entity\Inscription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker=Factory::create('fr_FR');
        //Evenements
        for($e=0;$e< 5;$e++) {
            $evenement = new Evenement();
            $evenement->setNom($faker->company)
                ->setStatus($faker->randomElement($array=array('En cours','Terminée')))
                ->setDatedebut($faker->dateTimeBetween('-6 months'))
                ->setDatefin($faker->dateTimeBetween('-4 months'))
                ->setDatecreation($faker->dateTime())
                ->setCapaciteaccueil($faker->randomDigitNotNull);

            //Persistance des données d'évènements'
            $manager->persist($evenement);

            //Inscription
            for ($p = 0; $p < mt_rand(2,4); $p++) {
                $inscription = new Inscription();
                $inscription->setNom($faker->firstName())
                    ->setPrenom($faker->lastName)
                    ->setEmail($faker->email)
                    ->setTelephone($faker->phoneNumber)
                    ->setEvenement($evenement);

                //Persistance des données de participants
                $manager->persist($inscription);

            }
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
