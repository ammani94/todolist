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
use App\Entity\TodolistItems;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TodolistController extends AbstractController
{
    #[Route('/add_todolist')]
    public function insertData(Request $request,EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $data = json_decode($request->getContent(), true);
        $userId = $session->get('user_id');
        $Todolist = new Todolist();
        
        $Todolist->setName($data['name']);
        $Todolist->setUserId($userId);
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
    public function fetchList(EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $userId = $session->get('user_id');
        $userUsername = $session->get('user_username');
        if (!$userId) {
            return $this->json([
                'success' => false,
                'message' => 'Non autorisé',
            ], 401);
        }
        $todolists = $entityManager->getRepository(Todolist::class)->findBy(
            ['user_id' => $userId]
        );
        $todolistsArray = array_map(function ($todolist) {
            return [
                'id' => $todolist->getId(),
                'name' => $todolist->getName(),
                'path' => '/details/' . $todolist->getId(),
            ];
        }, $todolists);

        return $this->json([
            'success' => true,
            'todolists' => $todolistsArray,
        ]);
    }

    #[Route('/fetch/todolist/{id}')]
    public function fetchTodolist(EntityManagerInterface $entityManager, int $id): Response
    {
        $repository = $entityManager->getRepository(TodolistItems::class);
        
        $todolist = $repository->findBy(
            ['todolist_id' => $id]
        );
        
        $todolistsArray = array_map(function ($todolist) {
            return [
                'id' => $todolist->getId(),
                'name' => $todolist->getName()
            ];
        }, $todolist);
        return $this->json([
            'success' => true,
            'todolists' => $todolistsArray,
        ]);
    }

    #[Route('/add_todolistItem/{id}')]
    public function insertDataTodolistItem(Request $request,EntityManagerInterface $entityManager, int $id): Response
    {
        $data = json_decode($request->getContent(), true);
        
        $Todolist = new TodolistItems();
        $Todolist->setName($data['name']);
        $Todolist->setTodolistId($id);
        
        $entityManager->persist($Todolist);

        $entityManager->flush();
        return $this->json([
        'success' => true,
        'message' => 'Création item OK',
        'todolist' => [
            'id' => $Todolist->getId(),
            'name' => $Todolist->getName()
            ],
        ]);
    }

    #[Route('/delete_todolistItem/{id}')]
    public function deleteDataTodolistItem(Request $request,EntityManagerInterface $entityManager, int $id)
    {
        $repository = $entityManager->getRepository(TodolistItems::class);
        $product = $repository->find($id);
        if ($product) {
            $entityManager->remove($product);
            $entityManager->flush();
            return $this->fetchTodolist($entityManager, $id);
        } else {
            return $this->json([
                'success' => false,
                'message' => 'Élément non trouvé'
            ]);
        }
    }

    #[Route('/delete_todolist/{id}')]
    public function deleteDataTodolist(Request $request,EntityManagerInterface $entityManager, int $id)
    {
        $repository = $entityManager->getRepository(TodolistItems::class);
        
        $todolist = $repository->findBy(
            ['todolist_id' => $id]
        );
        foreach($todolist as $key => $object) {
            $entityManager->remove($object);
            $entityManager->flush();
        }

        $repository = $entityManager->getRepository(Todolist::class);
        $product = $repository->find($id);
        if ($product) {
            $entityManager->remove($product);
            $entityManager->flush();
            return $this->fetchTodolist($entityManager, $id);
        } else {
            return $this->json([
                'success' => false,
                'message' => 'Élément non trouvé'
            ]);
        }
    }
}