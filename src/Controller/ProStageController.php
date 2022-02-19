<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;


use App\Entity\Entreprise;
use App\Entity\Stage;
use App\Entity\Formation;

use App\Repository\StageRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\FormationRepository;


use Doctrine\ORM\EntityManagerInterface;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="pro_stage_accueil")
     */
    public function index(StageRepository $stageRepository): Response
    {
        /// PAGE D'ACCUEIL DE L'APPLICATION PROSTAGE ///

        // Requête en BD consistant à récupérer tous les stages afin de les lister.
        $stagesAvecEntreprise = $stageRepository->findAllStagesAvecEntreprise();

        // Passage des variables à la vue
        return $this->render('pro_stage/index.html.twig',['stagesAvecEntreprise'=>$stagesAvecEntreprise]);
    }

    /**
     * @Route("/entreprises", name="pro_stage_entreprises")
     */
    public function listerEntreprises(EntrepriseRepository $entrepriseRepository): Response
    {
        // Requête en BD consistant à récupérer toutes les entreprises afin de les lister.
        $entreprises = $entrepriseRepository->findAll();

        // Passage des variables à la vue
        return $this->render('pro_stage/listeEntreprises.html.twig',['entreprises'=>$entreprises]);
    }

    /**
     * @Route("/formations", name="pro_stage_formations")
     */
    public function listerFormations(FormationRepository $formationRepository): Response
    {
        // Requête en BD consistant à récupérer toutes les formations afin de les lister.
        $formations = $formationRepository->findAll();

        // Passage des variables à la vue
        return $this->render('pro_stage/listeFormations.html.twig',['formations'=>$formations]);
        
    }

    /**
     * @Route("/stages/{id}", name="pro_stage_stages")
     */
    public function detaillerStage(StageRepository $stageRepository, $id): Response
    {
        // Requête en BD consistant à récupérer le stage associé à l'id en paramètres
        $stage = $stageRepository->find($id);

        // Passage des variables à la vue
        return $this->render('pro_stage/stages.html.twig',['stage'=>$stage]);
    }


    /**
     * @Route("/stages/entreprise/{nom}", name="pro_stage_stages_par_nom_entreprise")
     */
    public function listerStagesParNomEntreprise(StageRepository $stageRepository ,$nom): Response
    {
        // Requête en BD consistant à récupérer l'entreprise associée à l'id en paramètres
        $stagesParNomEntreprise = $stageRepository->findByNomEntreprise($nom);

        // Passage des variables à la vue
        return $this->render('pro_stage/stagesParNomEntreprise.html.twig', ['stagesParNomEntreprise'=> $stagesParNomEntreprise, 'nomEntreprise' => $nom]);
        
    }

    /**
     * @Route("/stages/formation/{nom}", name="pro_stage_stages_par_nom_formation")
     */
    public function listerStagesParFormation(StageRepository $stageRepository, $nom): Response
    {
        // Requête en BD consistant à récupérer la formation associée à l'id en paramètres
        $stagesParNomFormation = $stageRepository->findByNomFormation($nom);

        // Passage des variables à la vue
        return $this->render('pro_stage/stagesParFormation.html.twig', ['stagesParNomFormation'=> $stagesParNomFormation, 'nomFormation' => $nom]);
    }

    /**
     * @Route("/nouvelleEntreprise", name="pro_stage_nouvelle_entreprise")
     */
    public function ajouterNouvEntreprise(): Response
    {
        // Création d'une nouvelle entreprise initialement vierge
        $entreprise = new Entreprise();

        // Création d'un objet formulaire pour ajouter une entreprise
        $formulaireEntreprise = $this   -> createFormBuilder($entreprise)
                                        -> add('nom', TextType::class)
                                        -> add('activite', TextareaType::class)
                                        -> add('adresse', TextareaType::class)
                                        -> add('urlsite', UrlType::class)
                                        -> getForm();
        // Afficher la page d'ajout d'une entreprise
   
        return $this->render('pro_stage/formulaireEntreprise.html.twig',['vueFormulaireEntreprise' => $formulaireEntreprise -> createView()]);
    }

    /**
     * @Route("/entreprises/modifier/{id}", name="pro_stage_modifier_entreprise")
     */
    public function modifierEntreprise(Entreprise $entreprise): Response
    {
        // Création d'un objet formulaire pour ajouter une entreprise
        $formulaireEntreprise = $this   -> createFormBuilder($entreprise)
                                        -> add('nom', TextType::class)
                                        -> add('activite', TextareaType::class)
                                        -> add('adresse', TextareaType::class)
                                        -> add('urlsite', UrlType::class)
                                        -> getForm();
        // Afficher la page d'ajout d'une entreprise
   
        return $this->render('pro_stage/formulaireEntreprise.html.twig',['vueFormulaireEntreprise' => $formulaireEntreprise -> createView()]);
    }




    

    
}
