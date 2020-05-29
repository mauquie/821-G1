<?php

namespace App\Controller\Editor;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditorController extends AbstractController
{

    /** 
     * @Route("/edition", name="editor")
     */
    public function index()
    {
        
        return $this->render('editor/index.html.twig', [
            'current_menu' => 'active_editor',
        ]);
    }
}