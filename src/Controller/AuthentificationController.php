<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Security\UtilisateursAuthentificationAuthenticator;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthentificationController extends AbstractController
{
    /**
     * @Route("/login", name="app_login", methods={"GET","POST"}))
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
         return $this->redirectToRoute('profil');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('Security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/profil/", name="app_profil", methods={"GET","POST"}))
     */
    public function profil(AuthenticationUtils $authenticationUtils)
    {
        
        $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render('security/profil.html.twig', [
            'error' => $error,
            ]);
        
    }

     /**
     * @Route("/profil/modif/{id}", name="profil_edit",  methods={"GET","POST"}))
     */
    public function editProfil(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, UtilisateursAuthentificationAuthenticator $authenticator)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $user = new Utilisateurs(); //indique la la table utilisateurs va être utilisé en tant qu'objet
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setUserPassword(     // donne un mot de passe crypté pour la sécurité
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData() //obtient la donnée
                )

            );
            $user->setUserDateInscription(new \DateTime()); //ajoute la date d'inscription de l'utilisateur


            $entityManager = $this->getDoctrine()->getManager(); //contient toute la requête
            $entityManager->persist($user); //force la requête
            $entityManager->flush(); //envoi le tout dans la bdd

        }
        return $this->render('security/editUser.html.twig', [
            'registrationFormType' => $form->createView(),
            'error' => $error]);
        
    }

}
