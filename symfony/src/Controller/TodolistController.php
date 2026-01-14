<?php

namespace App\Controller;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Todolist;
use Doctrine\ORM\EntityManagerInterface;

class TodolistController extends AbstractController
{
    #[Route('/add_todolist')]
    public function insertData(Request $request,EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        error_log(print_r($data,1));
        $Todolist = new Todolist();
        
        $Todolist->setName($data['name']);
        
        $entityManager->persist($Todolist);

        $entityManager->flush();
        return $this->json([
        'success' => true,
        'message' => 'Création todolist OK',
        'todolist' => [
            'id' => $Todolist->getId(),
            'name' => $Todolist->getName(),
            'path' => '/about/' . $Todolist->getId(),
            ],
        ]);
    }

    #[Route('/fetch')]
    public function fetchList(EntityManagerInterface $entityManager): Response
    {
        $todolists = $entityManager->getRepository(Todolist::class)->findAll();

        $todolistsArray = array_map(function ($todolist) {
            return [
                'id' => $todolist->getId(),
                'name' => $todolist->getName(),
                'path' => '/about/' . $todolist->getId(),
            ];
        }, $todolists);

        return $this->json([
            'success' => true,
            'todolists' => $todolistsArray,
        ]);
    }
}