<?php

namespace App\Controller;

use App\Entity\Equipment;
use App\Repository\EquipmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class EquipmentController extends AbstractController
{
    /**
     * @Route("/nos-equipement", name="equipment")
     */
    public function index(EquipmentRepository $repository)
    {
        
        return $this->render('equipment/index.html.twig', [
            'current_menu' => 'active_equipment',
            'equipments' => $repository->findAll()
        ]);
    }
    
}