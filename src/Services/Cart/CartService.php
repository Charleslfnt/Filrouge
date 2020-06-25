<?php

namespace App\Services\Cart;

use App\Repository\ProduitsRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService {

    protected $session;
    protected $produitsRepository;

    public function __construct(SessionInterface $session, ProduitsRepository $produitsRepository){

        $this->session = $session;
        $this->produitsRepository = $produitsRepository;
    }

    public function add($id) {
        $panier = $this->session->get('panier', []);

        if(!empty($panier[$id])) {   //si le produit est déjà dans le panier on en rajoute 1 exemplaire
            $panier[$id]++;
        } else {
            $panier[$id] = 1;  //sinon il y en a 1
        }
    
        $this->session->set('panier', $panier); //on save le panier dans la session
    }

    public function remove(int $id) {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) { //si le panier n'est pas vide
            unset($panier[$id]);
        }

        $this->session->set('panier', $panier);
    } 

    public function getFullCart() : array {
    $panier = $this->session->get('panier', []); //prend ce qui a dans la session qui s'appelle panier

    $panierWithData = [];

    foreach($panier as $id => $quantity) {
        $panierWithData[] = [
            'produit' => $this->produitsRepository->find($id),
            'quantity' => $quantity
        ];
    }
        return $panierWithData; //du fait que on à déclaré à la fonction que c'est un tableau et qu'il ne retourne rien, on retourne le panier avec le contenu
   }

    public function getTotal() : float {
    $total = 0;

    foreach($this->getFullCart() as $item) { // pour chaque objet du panier on additionne les produits et on les multiplies par leur quantité
        $total += $item['produit']->getProPrix() * $item['quantity'];
    }
    return $total;  
   }
}