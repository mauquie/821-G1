<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Borrow;
use App\Repository\UserRepository;
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
    public function index(BorrowRepository $repositoryBorrow, UserRepository $repositoryUser, Borrow $borrow)
    {
        $user->getEmail();
        $email = $repository->findBy([ 'user' => $user ]);
        
        $equipment = $borrow->getEquipment();
        $borrowStart = $borrow->getBorrowStart();
        $borrowEnd = $borrow->getBorrowEnd();
        $quantity = $borrow->getQuantity();
        
        $borrows = $repository->find($email, $equipment, $borrowStart, $borrowEnd, $quantity);
        
        return $this->render('borrow/borrows.html.twig', [
            'current_menu' => 'active_borrow',
            'borrows' => $borrows,
            'email' => $user
        ]);
    }
    
}