<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Panier;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends AbstractController
{

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/register', name: 'app_signup')]
    public function signUp(Request $request, UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $alreadyUser = $userRepository->findBy(['email' => $user->getEmail()]);
            if (empty($alreadyUser)) {
                $panier = new Panier();
                $panier->setUser($user);
                $this->entityManager->persist($panier);
                
                $user->setRoles(['ROLE_USER']);
                $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
                $this->entityManager->persist($user);
                $this->entityManager->flush();
            }else{
                $form['email']->addError(new FormError('This email have already been used'));
            }
        }

        return $this->render('user/sign-up.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route('/account', name: 'app_account')]
    public function account(UserInterface $userInterface): Response
    {
        if ($userInterface) {
            return $this->render('user/account.html.twig');
        } else {
            return $this->redirectToRoute('login');
        }
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(){}
}
