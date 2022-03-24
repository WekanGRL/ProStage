<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/inscription", name="app_inscription")
     */
    public function inscription(Request $requeteHttp, EntityManagerInterface $manager): Response
    {
        // Créer un utilisateur vide        
        $user = new User();

        // Création d'un objet formulaire pour récupérer les données saisies par l'utilisateur
        $formUser = $this->createForm(UserType::class, $user);

        // Récupération de la requête HTTP
        $formUser->handleRequest($requeteHttp);

        // Traiter les données du formulaire s'il a été soumis
        if($formUser->isSubmitted() && $formUser->isValid()){
            // Enregistrer le stage en BD
            //$manager->persist ($user);
            //$manager->flush();
        
            // Rediriger l’utilisateur vers la page affichant la liste des stages
            return $this->redirectToRoute('pro_stage_accueil');
        }

        // Afficher le formulaire dédié à un stage   
        return $this->render('pro_stage/formulaireInscription.html.twig',
                            ['vueFormulaireInscription' => $formUser->createView()]);
    }
}
