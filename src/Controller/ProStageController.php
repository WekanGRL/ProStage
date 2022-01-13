<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="pro_stage_accueil")
     */
    public function index(): Response
    {
        return $this->render('pro_stage/index.html.twig');
    }

    /**
     * @Route("/entreprises", name="pro_stage_listeEntreprises")
     */
    public function listeEntreprises(): Response
    {
        return $this->render('pro_stage/listeEntreprises.html.twig');
    }

    /**
     * @Route("/formations", name="pro_stage_listeFormations")
     */
    public function listeFormations(): Response
    {
        return $this->render('pro_stage/listeFormations.html.twig');
    }

    /**
     * @Route("/stages", name="pro_stage_listeStages")
     */
    public function listeStages(): Response
    {
        return $this->render('pro_stage/listeStages.html.twig');
    }

    /**
     * @Route("/stages/{id}", name="pro_stage_stages")
     */
    public function detailStage($id): Response
    {
        return $this->render('pro_stage/stages.html.twig', [
            'id_stage' => $id,
        ]);
    }

    /**
     * @Route("/stages/entreprises", name="pro_stage_entreprisesStagePropose")
     */
    public function entreprisesStagePropose(): Response
    {
        // à compléter
    }

    /**
     * @Route("/stages/entreprise", name="pro_stage_stages")
     */
    public function stagesParEntreprise(): Response
    {
        // à compléter
    }

    /**
     * @Route("/stages/{id}", name="pro_stage_stages")
     */
    public function formationsStagePropose(): Response
    {
        // à compléter
    }

    /**
     * @Route("/stages/{id}", name="pro_stage_stages")
     */
    public function stagesParFormation(): Response
    {
        // à compléter
    }

    
}
