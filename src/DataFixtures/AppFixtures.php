<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Stage;
use App\Entity\Formation;
use App\Entity\Entreprise;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création d'un générateur de données avec Faker
        $faker = \Faker\Factory::create('fr_FR');

        /* CREATION DES DONNEES RELATIVES AUX FORMATIONS (NON ALEATOIRES) */

        /**************/
        /**************/

        /// BUT INFO ///

        // Création d'un nouvel objet Formation
        $butInfo = new Formation();

        // Définition du nom long de la formation
        $butInfo->setNomLong('Bachelor Universitaire Technologique d\'Informatique');

        // Définition du nom court de la formation
        $butInfo->setNomCourt('BUT INFO');

        // Intégration du nouvel objet Formation dans un tableau de formations (utile plus tard pour les stages)
        $tableauFormations[]=$butInfo;

        // Enregistrement de la formation créée
        $manager->persist($butInfo);

        /**************/
        /**************/

        /// LP PROG ///

        // Création d'un nouvel objet Formation
        $lpProg = new Formation();

        // Définition du nom long de la formation
        $lpProg->setNomLong('Licence Professionnelle de Programmation Avancée');

        // Définition du nom court de la formation
        $lpProg->setNomCourt('LP PROG');

        // Intégration du nouvel objet Formation dans un tableau de formations (utile plus tard pour les stages)
        $tableauFormations[]=$lpProg;

        // Enregistrement de la formation créée
        $manager->persist($lpProg);

        /**************/
        /**************/

        /// BUT GIM ///

        // Création d'un nouvel objet Formation
        $butGim = new Formation();

        // Définition du nom long de la formation
        $butGim->setNomLong('Bachelor Universitaire Technologique de Génie Industriel et Maintenance');

        // Définition du nom court de la formation
        $butGim->setNomCourt('BUT GIM');

        // Intégration du nouvel objet Formation dans un tableau de formations (utile plus tard pour les stages)
        $tableauFormations[]=$butGim;

        // Enregistrement de la formation créée
        $manager->persist($butGim);

        /**************/
        /**************/

        /// LP NUM ///

        // Création d'un nouvel objet Formation
        $lpNum = new Formation();

        // Définition du nom long de la formation
        $lpNum->setNomLong('Licence Professionnelle des Métiers du Numérique');

        // Définition du nom court de la formation
        $lpNum->setNomCourt('LP NUM');

        // Intégration du nouvel objet Formation dans un tableau de formations (utile plus tard pour les stages)
        $tableauFormations[]=$lpNum;

        // Enregistrement de la formation créée
        $manager->persist($lpNum);

        /**************/
        /**************/

        // Définition du nombre d'entreprises de test que l'on veut implémenter dans notre base
        $nbEntreprises = 15;
        for ($i = 1; $i <= $nbEntreprises; $i++) { 

            // Création d'un nouvel objet Entreprise
            $entreprise = new Entreprise();

            // Définition de l'activité de l'entreprise (45 caractères max.)
            $entreprise->setActivite($faker->realText($maxNbChars = 45, $indexSize = 2));

            // Définition de l'adresse de l'entreprise (avec la méthode address de faker)
            $entreprise->setAdresse($faker->address());

            // Définition du nom de l'entreprise (avec la méthode company de faker)
            $entreprise->setNom($faker->company());            
            
            // Définition de l'url du site (avec la méthode url de faker)
            $entreprise->setUrlsite($faker->url());

            // Intégration du nouvel objet Entreprise dans un tableau d'entreprises (utile plus tard pour les stages)
            $tableauEntreprises[]= $entreprise;

            // Enregistrement de l'entreprise créée
            $manager->persist($entreprise);
        }    

        // Définition d'un premier tableau contenant le poste du stage (première partie de l'intitulé du stage)
        $tableauPoste= array("Maintenance", "Assistance","Responsable","Développement","Réparation", "Conception", "Analyse");
        // Définition d'un second tableau contenant le domaine du stage (seconde partie de l'intitulé du stage)
        $tableauDomaine = array(" en Cybersécurité"," en Ménage", " en Programmation Web" ," en Base de Données"," en POO"," en Physique Quantique", " en Apéro");

        // Définition du nombre de stages à implémenter
        $nbStages=45;
    
       for ($i=1; $i <= $nbStages; $i++)
       {    
            // Création d'un nouvel objet Stage
            $stage = new Stage();

            // Définition du titre du stage (on choisit un indice au hasard pour les deux tableaux afin de faire une association aléatoire)
            $stage->setTitre($tableauPoste[$faker->numberBetween($min=0,$max=count($tableauPoste)-1)].$tableauDomaine[$faker->numberBetween($min=0,$max=count($tableauDomaine)-1)]);
            
            // Définition de la description du stage (grâce à la méthode catchPhrase de faker)
            $stage->setDescription($faker->catchPhrase());

            // Définition de l'email de contact du stage (grâce à la méthode email de faker)
            $stage->setEmailContact($faker->email());

            // Définition de l'entreprise à laquelle est associé le stage (on choisit un indice au hasard parmi le tableau des entreprises défini plus tôt)
            $stage->setEntreprises($tableauEntreprises[$faker->numberBetween($min=0,$max=count($tableauEntreprises)-1)]);

            // Définition de la liste des formations concernées par ce stage
            for ($j=0 ; $j < $faker->numberBetween($min=1,$max=4) ; $j++ ) 
            { 
                $numFormation = $faker->unique->numberBetween($min=0,$max=3);
                $formationAjout = $tableauFormations[$numFormation];
                $stage->addFormation($formationAjout);
            }

            // Enregistrement du stage en base de données
            $manager->persist($stage);

            // Réinitialisation de la variable unique
            $faker->unique($reset=true);
           

       }

       $manager->flush();
    }
}

