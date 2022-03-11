<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use App\Entity\Formation;
use App\Entity\Stage;
use App\Form\StageType;
use App\Repository\EntrepriseRepository;
use App\Repository\FormationRepository;
use App\Repository\StageRepository;


use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;




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
     * @Route("/ajouter/entreprise", name="pro_stage_nouvelle_entreprise")
     */
    public function ajouterNouvEntreprise(Request $requeteHttp, EntityManagerInterface $manager): Response
    {
        // Création d'une nouvelle entreprise initialement vierge
        $entreprise = new Entreprise();

        // Création d'un objet formulaire pour ajouter une entreprise
        $formulaireEntreprise = $this-> createForm(EntrepriseType::class, $entreprise);

        // Récupération des données dans $entreprise si elles ont été soumises
        $formulaireEntreprise->handleRequest($requeteHttp);

        // Traiter les données du formulaire s'il a été soumis
        if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid()){
            // Enregistrer l'entreprise en BD
            $manager->persist ($entreprise);
            $manager->flush();

            // Rediriger l’utilisateur vers la page affichant la liste des entreprises
            return $this->redirectToRoute('pro_stage_entreprises');
        }


        // Afficher le formulaire dédié à une entreprise  
        return $this->render('pro_stage/formulaireEntreprise.html.twig',
                            ['vueFormulaireEntreprise' => $formulaireEntreprise->createView()]);
    }

    /**
     * @Route("/modifier/entreprise/{id}", name="pro_stage_modifier_entreprise")
     */
    public function modifierEntreprise(Request $requeteHttp, EntityManagerInterface $manager, Entreprise $entreprise): Response
    {
        // Création d'un objet formulaire pour modifier l'entreprise donnée en paramètres
        $formulaireEntreprise = $this-> createForm(EntrepriseType::class, $entreprise);

        // Récupération des données dans $entreprise si elles ont été soumises
        $formulaireEntreprise->handleRequest($requeteHttp);

        // Traiter les données du formulaire s'il a été soumis
        if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid()){
            // Enregistrer l'entreprise en BD
            $manager->persist ($entreprise);
            $manager->flush();
        
            // Rediriger l’utilisateur vers la page affichant la liste des entreprises
            return $this->redirectToRoute('pro_stage_entreprises');
        }


        // Afficher le formulaire dédié à une entreprise   
        return $this->render('pro_stage/formulaireEntreprise.html.twig',
                            ['vueFormulaireEntreprise' => $formulaireEntreprise->createView()]);
    }

    /**
     * @Route("/ajouter/stage", name="pro_stage_nouveau_stage")
     */
    public function ajouterStage(Request $requeteHttp, EntityManagerInterface $manager): Response
    {
        // Création d'un nouveau stage initialement vierge        
        $stage = new Stage();

        // Création d'un objet formulaire pour récupérer les données saisies par l'utilisateur
        $formulaireStage = $this->createForm(StageType::class, $stage);

        // Récupération de la requête HTTP
        $formulaireStage->handleRequest($requeteHttp);

        // Traiter les données du formulaire s'il a été soumis
        if($formulaireStage->isSubmitted() && $formulaireStage->isValid()){
            // Enregistrer le stage en BD
            $manager->persist ($stage);
            $manager->flush();
        
            // Rediriger l’utilisateur vers la page affichant la liste des stages
            return $this->redirectToRoute('pro_stage_accueil');
        }

        // Afficher le formulaire dédié à un stage   
        return $this->render('pro_stage/formulaireStage.html.twig',
                            ['vueFormulaireStage' => $formulaireStage->createView()]);
    }




    

    
}
