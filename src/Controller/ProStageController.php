<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Entreprise;
use App\Entity\Stage;
use App\Entity\Formation;
use App\Repository\StageRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\FormationRepository;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="pro_stage_accueil")
     */
    public function index(): Response
    {

        /// PAGE D'ACCUEIL DE L'APPLICATION PROSTAGE ///

        // Requête en BD consistant à récupérer tous les stages afin de les lister.
        $stages = $this->getDoctrine()->getRepository(Stage::class)->findAll();

        // Passage des variables à la vue
        return $this->render('pro_stage/index.html.twig',['stages'=>$stages]);
    }

    /**
     * @Route("/entreprises", name="pro_stage_entreprises")
     */
    public function listerEntreprises(): Response
    {
        // Requête en BD consistant à récupérer toutes les entreprises afin de les lister.
        $entreprises = $this->getDoctrine()->getRepository(Entreprise::class)->findAll();

        // Passage des variables à la vue
        return $this->render('pro_stage/listeEntreprises.html.twig',['entreprises'=>$entreprises]);
    }

    /**
     * @Route("/formations", name="pro_stage_formations")
     */
    public function listerFormations(): Response
    {
        // Requête en BD consistant à récupérer toutes les formations afin de les lister.
        $formations = $this->getDoctrine()->getRepository(Formation::class)->findAll();

        // Passage des variables à la vue
        return $this->render('pro_stage/listeFormations.html.twig',['formations'=>$formations]);
        
    }

    /**
     * @Route("/stages/{id}", name="pro_stage_stages")
     */
    public function detaillerStage($id): Response
    {
        // Requête en BD consistant à récupérer le stage associé à l'id en paramètres
        $stage = $this->getDoctrine()->getRepository(Stage::class)->find($id);

        // Passage des variables à la vue
        return $this->render('pro_stage/stages.html.twig',['stage'=>$stage]);
    }


    /**
     * @Route("/stages/entreprise/{id}", name="pro_stage_stagesParEntreprise")
     */
    public function listerStagesParEntreprise($id): Response
    {
        // Requête en BD consistant à récupérer l'entreprise associée à l'id en paramètres
        $entreprise = $this->getDoctrine()->getRepository(Entreprise::class)->find($id);

        // Passage des variables à la vue
        return $this->render('pro_stage/stagesParEntreprise.html.twig', ['entreprise'=> $entreprise]);
        
    }

    /**
     * @Route("/stages/formation/{id}", name="pro_stage_stagesParFormation")
     */
    public function listerStagesParFormation($id): Response
    {
        // Requête en BD consistant à récupérer la formation associée à l'id en paramètres
        $formation = $this->getDoctrine()->getRepository(Formation::class)->find($id);

        // Passage des variables à la vue
        return $this->render('pro_stage/stagesParFormation.html.twig', ['formation'=> $formation]);
    }

    
}
