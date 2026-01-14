<?php

namespace App\Entity;

use App\Repository\TodolistItemsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TodolistItemsRepository::class)]
class TodolistItems
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $todolist_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getTodolistId(): ?int
    {
        return $this->todolist_id;
    }

    public function setTodolistId(int $todolist_id): static
    {
        $this->todolist_id = $todolist_id;

        return $this;
    }
}
