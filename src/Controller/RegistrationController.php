<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Entity\Personnel;
use App\Form\RegistrationFormType;
use App\Security\UtilisateursAuthentificationAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, UtilisateursAuthentificationAuthenticator $authenticator): Response
    {
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
            $user->setUserRole(0);
            $user->setUserCoef(0);

            $entityManager = $this->getDoctrine()->getManager(); //contient toute la requête
            $entityManager->persist($user); //force la requête
            $entityManager->flush(); //envoi le tout dans la bdd

            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationFormType' => $form->createView(),
        ]);
    }
}
