<?php

namespace App\Controller;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;

class ApiController extends AbstractController
{
    #[Route('/api/formulaire')]
    public function handleForm(Request $request,EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        
        if (count($data) > 0) {
            $users = new Users();
            $users->setUsername($data['username']);
            $users->setPassword($data['password']);
            $users->setMessage($data['message']);

            $entityManager->persist($users);

            $entityManager->flush();
            return $this->json([
                'success' => true,
                'message' => 'Données reçues avec succès !',
                'id' => $users->getId(),
            ]);
        }
            return $this->json([
                'success' => false,
                'message' => 'Erreur',
                'data' => $data,
            ]);        
    }
}