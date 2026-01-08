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

class ApiAuthController extends AbstractController
{
    #[Route('/login')]
    public function handleForm(Request $request,EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher): Response
    {
        $data = json_decode($request->getContent(), true);
        $repository = $entityManager->getRepository(Users::class);
        $users = new Users();
        $hashedPassword = $passwordHasher->hashPassword(
            $users,
            $data['password']
        );
        
        $User = $repository->findOneBy(['username' => $data['username'], 'password' => $hashedPassword]);
        if ($User !== null) {
            return $this->json([
                'success' => true,
                'message' => 'Données présentes !',
                'id' => $User,
            ]);
        }
        return $this->json([
            'success' => false,
            'message' => 'Données présentes !',
            'id' => $User,
        ]);
            
        
    }
}