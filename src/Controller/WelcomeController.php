<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\VarDumper\VarDumper;

class WelcomeController extends AbstractController
{
    #[Route('/welcome', name: 'app_welcome')]
    public function index(Request $request, AuthenticationUtils $authUtils): Response
    {
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();
        return $this->render('welcome/index.html.twig', [
            'controller_name' => 'WelcomeController',
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/', name: 'app_welcome2')]
    public function indexEmptyUrl(): Response
    {
        // TODO: make redirect to "/welcome"
        $error = '';
        return $this->render('welcome/index.html.twig', [
            'controller_name' => 'WelcomeController',
            'error' => $error,
            'last_username' => '',
        ]);
    }

    #[Route('/welcome/register', name:'welcome_register')]
    public function register(
        UserPasswordHasherInterface $userPasswordHasher,
        UserServices $userServices
    )
    {
        $newUser = $userServices->createUser($_POST, $userPasswordHasher);
        $userServices->saveUser($newUser);

        $error = false;
        $lastUsername = '';
        return $this->render('welcome/index.html.twig', [
            'controller_name' => 'WelcomeController',
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

}
