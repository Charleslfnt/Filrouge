<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UtilisateursRepository;
use App\Entity\Personnel;


class AdminController extends AbstractController
{
   /**
    * @Route("/admin", name="admin")
    */
    public function Admin(UtilisateursRepository $utilisateursRepository) {
         
     return $this->render('security/utilisateurs.html.twig', [
         'controller_name' => 'AdminController',
         'utilisateurs' => $utilisateursRepository->findAll()
     ]);
    }
}
