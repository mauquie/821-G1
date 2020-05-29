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
     * @Route("/emprunter", name="borrow")
     * @Security("is_granted('ROLE_USER')")
     */
    public function index()
    {
        
        return $this->render('borrow/index.html.twig', [
        ]);
    }
}