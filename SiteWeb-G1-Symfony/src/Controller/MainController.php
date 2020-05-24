<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('site-pages/home.html.twig', [
            'current_menu' => 'active_home'
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

}
