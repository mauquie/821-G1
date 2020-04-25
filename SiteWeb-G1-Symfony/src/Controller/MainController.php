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
        return $this->render('site-pages/home.html.twig', [
            'current_menu' => 'active_home'
        ]);
    }
    
    /**
     * @Route("/equipement", name="equipment")
     */
    public function equipement()
    {
        return $this->render('site-pages/equipment.html.twig', [ 
            'current_menu' => 'active_equipment'
        ]);
    }
    
    /**
     * @Route("/emprunt", name="borrow")
     */
    public function emprunt()
    {
        return $this->render('site-pages/borrow.html.twig', [
            'current_menu' => 'active_borrow'
        ]);
    }
    
    /**
     * @Route("/lieu", name="place")
     */
    public function lieu()
    {
        return $this->render('site-pages/place.html.twig', [
            'current_menu' => 'active_place'
        ]);
    }
    
    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('site-pages/contact.html.twig', [
            'current_menu' => 'active_contact'
        ]);
    }
}
