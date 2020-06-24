<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/administrateur", name="admin_")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/utilisateurs", name="interface_users")
     */
    public function usersList(UserRepository $users)
    {
        return $this->render('admin/users.html.twig', [ 
            'current_menu' => 'active_interface_users',
            'users' => $users->findAll() 
        ]);        
    }
    
    /**
     * @Route("/utilisateurs/modifier/{id}", name="set_users")
     * 
     */
    public function editUser(Request $request, User $user, EntityManagerInterface $entity_manager) 
    {
            
            $form = $this->createForm(EditUserType::class, $user);
            
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
                $entity_manager->flush();
                
                return $this->redirectToRoute('admin_interface_users');
            }
            
            return $this->render('admin/editUser.html.twig', [
                'current_menu' => 'active_edit_user',
                'formUser' => $form->createView()
            ]);
    } 
}