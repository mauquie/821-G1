<?php

namespace App\Controller;

use App\Entity\Equipment;
use App\Repository\EquipmentRepository;
//use App\Repository\BorrowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class BorrowController extends AbstractController
{

    /** 
     * @Route("/emprunter/{slug}", name="borrow")
     * @Security("is_granted('ROLE_USER')")
     */
    public function index(EquipmentRepository $equipments, string $slug)
    {
        // On récupère l'utilisateur connecté
        $user = $this->getUser();   
        
        // On récupère l'équipement qui appartient au slug de la page emprunte
        $equipment = $equipments->findOneBy([ 'slug' => $slug ]);  
        dump($equipment);
        
        return $this->render('borrow/index.html.twig', [
            'current_menu' => 'active_equipment',
            'equipment' => $equipment
        ]);
    }
}