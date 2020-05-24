<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class EquipmentController extends AbstractController
{
    /**
     * @Route("/nos-equipement", name="equipment")
     */
    public function index()
    {
        return $this->render('equipment/equipment.html.twig', [
            'current_menu' => 'active_equipment'
        ]);
    }
    
    
}