<?php

namespace App\Controller;

use App\Repository\BorrowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use \Datetime;

class MyBorrowingsController extends AbstractController
{

    /** 
     * @Route("/mes-emprunts", name="my_borrowings")
     * @Security("is_granted('ROLE_USER')")
     */
    public function index(BorrowRepository $borrows)
    {
        
        // On r�cup�re l'utilisateur connect�
        $user = $this->getUser();
        // On r�cup�re l'ID de l'utilisateur 
        $userId = $user->getId();
        
        // On r�cup�re l'utilisateur ayant pass� au moins un emprunt
        $userBorrow = $borrows->findOneBy([ 'user' => $userId ]);
        // On r�cup�re les diff�rents emprunts de l'utilisateur dans un tableau
        $borrow = $borrows->findBy([ 'user' => $userId ]);
        
        // Affiche les informations li�es � la BD r�cup�r�e dans une variable -- FACULTATIF
        dump($borrow);
        $date = new DateTime();
        $date = date_format($date, "d-m-Y H:00");
        
        return $this->render('myBorrowings/index.html.twig', [
            'current_menu' => 'active_borrow',
            'borrows' => $borrow,
            'borrow' => $userBorrow,
            'now' => $date
        ]);
    }
}