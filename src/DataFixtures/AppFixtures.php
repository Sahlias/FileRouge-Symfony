<?php

namespace App\DataFixtures;
use App\Entity\User;
use App\Entity\Reservation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Chambre;
use App\Entity\Categorie;
use Faker\Factory;



class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        
$libelle = [

    "Chambre double superieure",
    "Chambre double deluxe",
    "Suite Junior",
    
];


        
        $categories = [];

        for ($i = 0; $i < count($libelle); $i++) {
            $categorie = new Categorie();
            $categorie->setLibelle($faker->randomElement($libelle));
          
               $manager->persist($categorie);

            $categories[] = $categorie;
        }



$libelle = [

            "Chambre évasion ",
            "Chambre deluxe",
            "Suite Junior",
            "Chambre Loft Urbain ",
            "Chambre Vintage",
            "Suite Penthouse",
            "Chambre Contemporaine",
            "Suite Étoilée",
            "Chambre Sérénité",
            "Suite Exotique",
            "Suite Suite Royale",
            "Chambre Traditionnelle",
            "Chambre ambiance Cosy",
            "Chambre Oasis Urbaine",
            "Chambre Sérénité Naturelle",
            "Chambre Luxe Urbain",
            "Suite élégance chic",
            "Suite confort épuré",
            "Suite Raffinement Contemporain",
            "Chambre Harmonie Relaxante",

        ];
        $chambres = [];

        for ($j = 1; $j <= 20; $j++) {
            $chambre = new Chambre();
            
            $chambre->setTarif($faker->numberBetween(100, 500));
            $chambre->setetat($faker->boolean);
            $chambre->setLibelle($faker->randomElement($libelle));
            $chambre->setSuperficie($faker->numberBetween(16, 50) . ' m²');
            $chambre->setVueSurMer($faker->boolean);
            $chambre->setChainesaLaCarte($faker->boolean);
            $chambre->setClimatisation($faker->boolean);
            $chambre->setTelevisionaEcranPlat($faker->boolean);
            $chambre->setTelephone($faker->boolean);
            $chambre->setChainesSatellite($faker->boolean);
            $chambre->setChainesDuCable($faker->boolean);
            $chambre->setCoffreFort($faker->boolean);
            $chambre->setMaterielDeRepassage($faker->boolean);
            $chambre->setWiFiGratuit($faker->boolean);

            $categorie = $faker->randomElement($categories);

            $chambre->setCategorie($categorie);

            $manager->persist($chambre);

            $chambres[] = $chambre;
        }

        $users = [];

        for ($i = 0; $i < 5; $i++) {
            $user = new User();

            $user->setNom($faker->lastName);
            $user->setPrenom($faker->firstName);
            $user->setEmail($faker->email);
            $user->setAdresse($faker->address);
            $user->setDateDeNaissance($faker->dateTimeBetween('-100 years', '-18 years'));
            $user->setTelephone($faker->phoneNumber);
            $user->setPassword($faker->password);

            $manager->persist($user);

            $users[] = $user;
        }

        for ($j = 0; $j <= 5; $j++) {
            $reservation = new Reservation();

            $dateReservation = $faker->dateTimeBetween('-1 year', 'now');
            $dateSortie = $faker->dateTimeBetween($dateReservation, '+1 month');
            $dateEntrée = $faker->dateTimeBetween('-1 year', $dateSortie);

            $user = $faker->randomElement($users);
            $reservation->setUser($user);
            $reservation->setChambre($chambre);

            $reservation->setDateReservation($dateReservation);
            $reservation->setDateEntree($dateEntrée);
            $reservation->setDateSortie($dateSortie);

            $manager->persist($reservation);

        
        }

        $manager->flush();
    }
}