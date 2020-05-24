<?php

namespace App\Controller;

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
    public function index()
    {
        return $this->render('borrow/borrow.html.twig', [
            'current_menu' => 'active_borrow'
        ]);
    }
    
}