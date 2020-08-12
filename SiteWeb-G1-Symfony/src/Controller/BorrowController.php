<?php

namespace App\Controller;

use App\Entity\Equipment;
use App\Entity\User;
use App\Entity\Borrow;
use App\Form\BorrowType;
use App\Repository\EquipmentRepository;
//use App\Repository\BorrowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class BorrowController extends AbstractController
{

    /** 
     * @Route("/emprunter/{slug}", name="borrow")
     * @Security("is_granted('ROLE_USER')")
     */
    public function index(EquipmentRepository $equipments, string $slug, Request $request, EntityManagerInterface $manager)
    {
        
        $newBorrow = new Borrow();
        
        // On récupère l'utilisateur connecté
        $user = $this->getUser();  
        
        // On récupère l'équipement qui appartient au slug de la page emprunte
        $equipment = $equipments->findOneBy([ 'slug' => $slug ]);
        dump($equipment);
        
        
        $form = $this->createForm(BorrowType::class,$newBorrow,['quantity'=> $equipment->getStock()]);              
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $newBorrow->setUser($user);
            $newBorrow->setEquipment($equipment);
            
            $manager->persist($newBorrow);
            $manager->flush();
            
            return $this->redirectToRoute('my_borrowings');
        }
        
        return $this->render('borrow/index.html.twig', [
            'current_menu' => 'active_equipment',
            'equipment' => $equipment,
            'form' =>$form->createView()
        ]);
    }
}