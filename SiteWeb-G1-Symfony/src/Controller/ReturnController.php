<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EquipmentRepository;
use App\Repository\BorrowRepository;
use App\Form\ReturnType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use \DateTime;

class ReturnController extends AbstractController
{
    /**
     * @Route("/rendre/{id}", name="return")
     * @Security("is_granted('ROLE_USER')")
     */
    public function index(EquipmentRepository $equipments, BorrowRepository $borrows, int $id, Request $request, EntityManagerInterface $manager)
    {
        $date = new DateTime();
        $date = date_format($date, "d-m-Y H:00");
        
        
        $returnedContent = array();
        $returnedContent['current_menu'] = 'active_equipment';
        
        // On récupère l'utilisateur connecté
        $user = $this->getUser();
        
        // On récupère l'équipement qui appartient au slug de la page emprunte
        $borrow = $borrows->findOneBy([ 'id' => $id]);
        $equipment = $equipments->findOneBy([ 'id' => $borrow->getEquipment()]);
        dump($borrow);
        $returnedContent['borrow'] = $borrow;
        
        $oldQuantity = $borrow->getQuantity();
        
        $form = $this->createForm(ReturnType::class,$borrow, ['quantity'=> $borrow->getQuantity()]);
        $form->handleRequest($request);
        $returnedContent['form']= $form->createView();
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            if(($oldQuantity - $borrow->getQuantity() == 0)){
                $equipment->setStock($equipment->getStock() + $borrow->getQuantity());
                $borrow->setQuantity($oldQuantity - $borrow->getQuantity());
                $borrow->setBorrowEnd(DateTime::createFromFormat("d-m-Y H:00",$date));
            }
            else{
                $equipment->setStock($equipment->getStock() + $borrow->getQuantity());
                $borrow->setQuantity($oldQuantity - $borrow->getQuantity());
            }
            
            
            $manager->persist($borrow); // if we can AJAX response
            $manager->flush();// if we can AJAX response
            
            return $this->redirectToRoute('my_borrowings');
        }
        
        
        return $this->render('return/index.html.twig', [
            'controller_name' => 'ReturnController',
            'form' => $form->createView(),
            'limitTime' => $date
        ]);
    }
}
