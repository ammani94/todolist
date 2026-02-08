<?php

namespace App\Controller;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ApiAuthController extends AbstractController
{
    #[Route('/login')]
    public function login(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, SessionInterface $session): Response
    {
        $data = json_decode($request->getContent(), true);
        if (empty($data['username']) || empty($data['password'])) {
            return $this->json([
                'success' => false,
                'message' => 'Nom d\'utilisateur ou mot de passe manquant',
            ], 400);
        }

        $user = $entityManager->getRepository(Users::class)->findOneBy(['username' => $data['username']]);

        if (!$user || !$passwordHasher->isPasswordValid($user, $data['password'])) {
            return $this->json([
                'success' => false,
                'message' => 'Nom d\'utilisateur ou mot de passe incorrect',
            ], 401);
        }
        $session->set('user_id', $user->getId());
        $session->set('user_username', $user->getUsername());
        return $this->json([
            'success' => true,
            'message' => 'Connexion réussie',
            'user' => [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
            ],
        ]);
    }

    #[Route('/signup')]
    public function CreateAccount(Request $request,EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher): Response
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['username']) || empty($data['password'])) {
            return $this->json([
                'success' => false,
                'message' => 'Nom d\'utilisateur ou mot de passe manquant',
            ], 400);
        }

        $User = $entityManager->getRepository(Users::class)->findOneBy(['username' => $data['username']]);

        if ($User !== null) {
            return $this->json([
                'success' => false,
                'message' => 'Compte existant'
            ]);
        }

        $user = new Users();
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $data['password']
        );
        
        $user->setUsername($data['username']);
        $user->setPassword($hashedPassword);
        $entityManager->persist($user);

        $entityManager->flush();
        return $this->json([
            'success' => true,
            'message' => 'Compte créé',
            'user' => [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
            ],
        ]);
    }

    #[Route('/logout')]
    public function logout(SessionInterface $session): Response
    {
        $session->clear();

        return $this->json([
            'success' => true,
            'message' => 'Déconnexion réussie',
        ]);
    }

    #[Route('/user')]
    public function GetUserData(SessionInterface $session): Response
    {
        $userId = $session->get('user_id');
        $userUsername = $session->get('user_username');

        if ($userId === null) {
        return $this->json([
            'success' => false,
            'message' => 'Aucune session active',
        ], 401);
    }

        return $this->json([
            'success' => true,
            'user' => [
                'id' => $userId,
                'username' => $userUsername,
            ],
        ]);
    }
}