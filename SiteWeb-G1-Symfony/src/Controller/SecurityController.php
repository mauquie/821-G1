<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResetPassType;
use App\Form\ForgottenPassType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController
{
    
    /**
     * @Route("/connexion", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render('security/login.html.twig', [
            'current_menu' => 'active_login',
            'last_username' => $lastUsername,
            'error' => $error
        ]);
        
    }
    
    /**
     * @Route("/deconnexion", name="logout")
     */ 
    public function logout()
    {
        
    }
    
    /**
     * @Route("/oubli-mot-de-passe", name="forgotten_password")
     */
    public function oubliPass(Request $request, UserRepository $users, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator): Response
        {
            // On initialise le formulaire
            $form = $this->createForm(ForgottenPassType::class);
            
            // On traite le formulaire
            $form->handleRequest($request);
            
            // Si le formulaire est valide
            if ($form->isSubmitted() && $form->isValid()) {
                // On récupère les données
                $donnees = $form->getData();
                
                // On cherche un utilisateur ayant cet e-mail
                $user = $users->findOneByEmail($donnees['email']);
                
                // Si l'utilisateur n'existe pas
                if ($user === null) {
                    // On envoie une alerte disant que l'adresse e-mail est inconnue
                    $this->addFlash('danger', 'Cette adresse e-mail est inconnue');
                    
                    // On retourne sur la page de connexion
                    return $this->redirectToRoute('login');
                }
                
                // On génère un token
                $token = $tokenGenerator->generateToken();
                
                // On essaie d'écrire le token en base de données
                try{
                    $user->setResetToken($token);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($user);
                    $entityManager->flush();
                } catch (\Exception $e) {
                    $this->addFlash('warning', $e->getMessage());
                    return $this->redirectToRoute('login');
                }
                
                // On génère l'URL de réinitialisation de mot de passe
                $url = $this->generateUrl('reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);
                
                // On génère l'e-mail
                $message = (new \Swift_Message('Mot de passe oublie'))
                ->setFrom('no-reply@lycee-bourdelle.fr')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/reset_password.html.twig', 
                        ['token' => $token ]
                        ),
                    'text/html'
                    )
                ;
                
                // On envoie l'e-mail
                $mailer->send($message);
                
                // On crée le message flash de confirmation
                $this->addFlash('message', 'E-mail de reinitialisation du mot de passe envoye !');
                
                // On redirige vers la page de login
                return $this->redirectToRoute('login');
            }
            
            // On envoie le formulaire à la vue
            return $this->render('security/forgotten_password.html.twig',[
                'current_menu' => 'active_forgotten_password',
                'forgottenPassForm' => $form->createView()
                
            ]);
    }
    
    /**
     * @Route("/reinitialiser-mot-de-passe/{token}", name="reset_password")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {
        // On initialise le formulaire
        $form = $this->createForm(ResetPassType::class);
        
        // On traite le formulaire
        $form->handleRequest($request);
        
        // On cherche un utilisateur avec le token donné
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['reset_token' => $token]);
        
        // Si l'utilisateur n'existe pas
        if ($user === null) {
            // On affiche une erreur
            $this->addFlash('danger', 'Token Inconnu');
            return $this->redirectToRoute('login');
        }
        
        if ($form->isSubmitted() && $form->isValid()) {
            // On supprime le token
            $user->setResetToken(null);
            
            // Encode le mot de passe réinitialiser
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                    )
                );
            
            // On stocke le nouveau mot de passe dans la base de donnée
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            
            // On crée le message flash
            $this->addFlash('message', 'Mot de passe mis a jour');
            
            // On redirige vers la page de connexion
            return $this->redirectToRoute('login');
        }else {
            // Si on n'a pas reçu les données, on affiche le formulaire
            return $this->render('security/reset_password.html.twig', [
                'current_menu' => 'active_reset_password',
                'resetPassForm' => $form->createView(),
                'token' => $token
            ]);
        }
        
    }
}   