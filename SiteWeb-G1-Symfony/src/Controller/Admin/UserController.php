<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\UserAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\EasyAdminFormType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;

class UserController extends EasyAdminController
{
    
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, UserAuthenticator $authenticator,\Swift_Mailer $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(EasyAdminFormType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Encode le mot de passe récupérer
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            
            // On génère un token et on l'enregistre
            $user->setActivationToken(md5(uniqid()));
            
            $user->setAccountActivation(false);
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            
            // On crée le message
            $message = (new \Swift_Message('Activation compte'))
            // On attribue l'expéditeur
            ->setFrom('yoan.guiraud@lycee-bourdelle.fr')
            // On attribue le destinataire
            ->setTo($user->getEmail())
            // On crée le texte avec la vue
            ->setBody(
                $this->renderView(
                    'emails/activation.html.twig', ['token' => $user->getActivationToken()]
                    ),
                'text/html'
                )
                ;
            $mailer->send($message);
        }
        
        return $this->render('admin', [
            'registrationForm' => $form->createView()
        ]);
    }
    
    // '../vendor/easycorp/easyadmin-bundle/src/Ressources/views/default/menu.html.twig'
}