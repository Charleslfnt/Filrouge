<?php

namespace App\Controller;

use App\Entity\Commandes;
use App\Form\CommandesType;
use App\Services\Cart\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(CartService $cartService)
    {
        return $this->render('Cart/cart.html.twig', [
            'items' => $cartService->getFullCart(), //Il passe le contenu du fullcart sous le nom "items"
            'total' => $cartService->getTotal()
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */
    public function add($id, CartService $cartService) {

        
      
        $cartService->add($id);

       return $this->redirectToRoute("cart_index");
    }

    /**
     *@Route("/panier/remove/{id}", name="cart_remove")
     */
    public function remove($id, CartService $cartService) {
       
        $cartService->remove($id);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/panier/informations", name="info_commande")
     */
    public function Commande(Request $request): Response
    {
        $commande = new Commandes();
        $form = $this->createForm(CommandesType::class, $commande);
        $form->handleRequest($request);
        $client = "";
 

        if ($form->isSubmitted() && $form->isValid()) { 

            $commande->setComDate(new \DateTime());
            $commande->setComObs("En cours");
            $commande->setTypePaiement(1);
           // $commande->setClient($client);
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commande);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('Cart/Commande.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
        ]);
    }
}