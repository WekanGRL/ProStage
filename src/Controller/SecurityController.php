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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
    public function inscription(Request $requeteHttp, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder): Response
    {
        // Créer un user vide        
        $user = new User();

        // Création d'un objet formulaire pour récupérer les données saisies par l'user
        $formUser = $this->createForm(UserType::class, $user);

        // Récupération de la requête HTTP
        $formUser->handleRequest($requeteHttp);

        if ($formUser->isSubmitted() && $formUser->isValid())
        {
            // Attribuer un rôle à l'user
            $user->setRoles(['ROLE_USER']);

            //Encoder le mot de passe de l'user
            $encodagePassword = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encodagePassword);

            // Enregistrer l'user en base de données
            $manager->persist($user);
            $manager->flush();

            // Rediriger l'user vers la page de login
            return $this->redirectToRoute('app_login');
        }

        // Afficher la page présentant le formulaire d'inscription
        return $this->render('security/formulaireInscription.html.twig',['vueFormulaireInscription' => $formUser->createView()]);
    }
}
