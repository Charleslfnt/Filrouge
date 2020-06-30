<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    /** 
     * @Route("/"
     * , name="home")
     */
    public function home()
    {
        return $this->render('Index/home.html.twig');
    }

 

  

    /**
     * @Route("/category"
     * , name="category")
     */
    public function category() 
    {
        return $this->render('Index/produits/category.html.twig');
    }

    /**
     * @Route("/service"
     * , name="service")
     */
    public function service()
    {
        return $this->render('Index/service/service.html.twig');
    }

    /**
     * @Route("/help"
     * , name="help")
     */
    public function help()
    {
        return $this->render('Index/service/help.html.twig');
    }

     /**
     * @Route("/about"
     * , name="about")
     */
    public function about()
    {
        return $this->render('Index/service/about.html.twig');
    }

    /**
     * @Route("/faq"
     * , name="faq")
     */
    public function faq()
    {
        return $this->render('Index/service/faq.html.twig');
    }  
}
