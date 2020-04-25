<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        
        $form->handleRequest($request); //analyse la request
        
        if($form->isSubmitted() && $form->isValid()) // si le form est envoyé
        {
            // Encode le mot de passe récupérer 
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            
            
            // Enregistrement de l'utilisateur 
            $manager->persist($user); //persiste l’info dans le temps
            $manager->flush(); //envoie les info à la BDD
            
            return $this->redirectToRoute('security_login');
        }
        return $this->render('security/registration.html.twig', [
            'current_menu' => 'active_registration',
            'form' => $form->createView()  
        ]);
    }
    
    /**
     * @Route("/connexion", name="security_login")
     */
    public function login()
    {
 
        return $this->render('security/login.html.twig', [
            'current_menu' => 'active_login'       
        ]);
    }
    
    /**
     * @Route("/deconnexion", name="security_logout")
     */ 
    public function logout()
    {
        
    }
}


    