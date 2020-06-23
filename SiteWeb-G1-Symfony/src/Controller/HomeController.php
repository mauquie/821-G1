<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {   
        // On récupère l'utilisateur connecté
        $user = $this->getUser();
        
        return $this->render('home/index.html.twig', [
            'current_menu' => 'active_home'
        ]);
    }

}
