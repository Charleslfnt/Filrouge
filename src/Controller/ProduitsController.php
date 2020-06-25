<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Form\ProduitsType;
use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\FileType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * @Route("/produits")
 */
class ProduitsController extends AbstractController
{
    /**
     * @Route("/", name="produits", methods={"GET"})
     */
    public function index(ProduitsRepository $produitsRepository): Response
    {
        return $this->render('produits/tableau.html.twig', [ //donne à la vue tout le contenu de la table produit sous forme de tableau
            'produits' => $produitsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/ajout", name="produits_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $produit = new Produits(); //déclare la table produits comme objet manipulable 
        $form = $this->createForm(ProduitsType::class, $produit); //crée le formulaire dédié à l'ajout
        $form->handleRequest($request); // indique que le formulaire est crée dans le but d'une requête

        if ($form->isSubmitted() && $form->isValid()) {  //si le formulaire est envoyé et valide, les instructions s'éxécutent

            $file = $produit->getProPhoto(); //nom du fichier
          
            $filename = md5(\uniqid()).'.'.$file->guessExtension(); //donne comme nom un Id unique au fichier
   
            $produit->setProPhoto($filename); // nouveau nom du fichier qui est l'id unique donné par la fonction au dessus
            $file->move($this->getParameter('uploads_directory'), $filename); //déplace le fichier dans le chemin donné dans le parameter du fichier services.yaml

            $produit->setProAjout(new \DateTime()); //met la date d'ajout dans la bdd

            $entityManager = $this->getDoctrine()->getManager(); //contient toute la requête
            $entityManager->persist($produit); //force la requête
            $entityManager->flush(); //envoi le tout dans la bdd

            return $this->redirectToRoute('produits');
        }

        return $this->render('produits/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="produits_show", methods={"GET"})
     */
    public function show(Produits $produit): Response //cette fonction montre le produits choisi avec son ID
    {
        return $this->render('produits/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="produits_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Produits $produit): Response //fonction d'édit
    {
        $form = $this->createForm(ProduitsType::class, $produit); //crée un formulaire basé sur l'entité Produits
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { //si le form est valide, la requête s'envoie
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produits'); //retour à la page d'affichage des produits
        }

        return $this->render('produits/_edit.html.twig', [ //affiche le form de modif 
            'produit' => $produit, //passe à la vue les produits
            'form' => $form->createView(), //passe le formulaire à la vue 
        ]);
    }

    /**
     * @Route("/{id}", name="produits_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Produits $produit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('produits');
    }

    /**
     * @Route("/guitaresbasses", name="guitares&basses", methods={"GET"})
     */
    public function guitaresBasses(ProduitsRepository $produitsRepository): Response
    {
        return $this->render('produits/guitares&basses.html.twig', [ //donne à la vue tout le contenu de la table produit sous forme de tableau
            'Guitares' => $produitsRepository->findAll(),
        ]);
    }
}
