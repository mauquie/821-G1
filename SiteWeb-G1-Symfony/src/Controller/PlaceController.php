<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class PlaceController extends AbstractController
{
    /**
     * @Route("/lieu", name="place")
     */
    public function index()
    {
        return $this->render('place/index.html.twig', [
            'current_menu' => 'active_place'
        ]);
    }
}