<?php

namespace App\Controller;

use App\Repository\BorrowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class BorrowController extends AbstractController
{

    /** 
     * @Route("/emprunt", name="borrow")
     * @Security("is_granted('ROLE_USER')")
     */
    public function index(BorrowRepository $borrows)
    {
        // On récupère l'utilisateur connecté
        $user = $this->getUser();
        // On récupère l'ID de l'utilisateur 
        $userId = $user->getId();
        
        // On récupère l'utilisateur ayant passé au moins un emprunt
        $userBorrow = $borrows->findOneBy([ 'user' => $userId ]);
        // On récupère les différents emprunts de l'utilisateur dans un tableau
        $borrow = $borrows->findBy([ 'user' => $userId ]);
        
        // Affiche les informations liées à la BD récupérée dans une variable -- FACULTATIF
        dump($borrow);
        
        return $this->render('borrow/borrows.html.twig', [
            'current_menu' => 'active_borrow',
            'borrows' => $borrow,
            'user' => $userBorrow
        ]);
    }
    
}