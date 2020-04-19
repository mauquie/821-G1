<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function accueil()
    {
        return $this->render('site/accueil.html.twig');
    }
    
    /**
     * @Route("/equipement", name="equipment")
     */
    public function equipement()
    {
        return $this->render('site/equipement.html.twig');
    }
    
    /**
     * @Route("/emprunt", name="borrow")
     */
    public function emprunt()
    {
        return $this->render('site/emprunt.html.twig');
    }
    
    /**
     * @Route("/lieu", name="place")
     */
    public function lieu()
    {
        return $this->render('site/lieu.html.twig');
    }
    
    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('site/contact.html.twig');
    }
}
