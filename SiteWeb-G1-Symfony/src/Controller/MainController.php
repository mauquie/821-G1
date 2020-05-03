<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
     * @Route("/gerer-equipement", name="manage_equipment")
     * @Security("is_granted('ROLE_EDITOR')")
     */
    public function manage_equipement()
    {
        return $this->render('editor/manageEquipment.html.twig', [
            'current_menu' => 'active_manage_equipment'
        ]);
    }
    
    /**
     * @Route("/emprunt", name="borrow")
     * @Security("is_granted('ROLE_USER')")
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
