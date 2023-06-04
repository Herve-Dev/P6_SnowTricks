<?php

namespace App\Controller;

use App\Form\NewPasswordType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use App\Service\EncryptService;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $this->addFlash('success', 'connexion reussi');

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/forgetPassword', name: 'app_forget_password')]
    public function forgetPassword(
        UserRepository $userRepository ,
        SendMailService $mail, 
        Request $request, 
        EncryptService $encrypt)
    {
        //On crée le formulaire
        $resetForm = $this->createForm(ResetPasswordType::class);

        $resetForm->handleRequest($request);
        if ($resetForm->isSubmitted() && $resetForm->isValid()) {
            //On va chercher l'utilisateur par son email
            $user = $userRepository->findOneBy(['email' => $resetForm->get('email')->getData()] );
            $idUser = $user->getId();

            if ($user) {
                //On génère un token de reinitialisation
                //$token = $tokenGeneratorInterface->generateToken();
                
                $token = $encrypt->encodeDataWithSignature($idUser, 'SECRET_SIGNATURE_DEMO');
                

                $url = $this->generateUrl('app_reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
                //dd($url);

                //On crée le mail
                $context = compact('url','user');

                //Envoi du mail
                $mail->send(
                    'no-reply@snowtricks.com',
                    $user->getEmail(),
                    'Rénitialisation de mot de passe',
                    'password_reset',
                    $context
                );
            }
            $this->addFlash('danger', 'Un problème est survenu');
        }


        return $this->render('security/reset.html.twig',[
            'resetForm' => $resetForm->createView()
        ]);
    }

    #[Route(path: '/resetPassword/{token}', name: 'app_reset_password')]
    public function resetPassword(string $token, Request $request, UserRepository $userRepository,EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, EncryptService $encrypt)
    {

        //On décode la data
        $decrypt = $encrypt->decodeDataWithSignature($token, 'SECRET_SIGNATURE_DEMO');
        if ($decrypt) {
            //On cherche l'utilisateur
            $user = $userRepository->findOneBy(['id' => intval($decrypt)]);
            
                if ($user) {
                    $form = $this->createForm(NewPasswordType::class);

                    $form->handleRequest($request);

                    if ($form->isSubmitted() && $form->isValid()) {
                        $user->setPassword(
                            $passwordHasher->hashPassword(
                                $user,
                                $form->get('password')->getData()
                            )
                        );
                        $em->persist($user);
                        $em->flush();

                        $this->addFlash('success', 'Mot de passe changé avec succès');
                        return $this->redirectToRoute('app_login');
                    }

                    return $this->render('security/new_password.html.twig', [
                        'passForm' => $form->createView()
                    ]);
                }
        }
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
