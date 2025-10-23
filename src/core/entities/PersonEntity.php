<?php

namespace MyProject\core\entities;

use InvalidArgumentException;

class PersonEntity
{
    private ?int $id;
    private string $name;
    private ?string $email;
    private ?string $createdAt;
    private ?string $updatedAt;
    private ?string $deletedAt;

    public function __construct(array $data = [])
    {
        $this->id         = $data['id']         ?? null;
        if(empty($data['name'])) {
            throw new InvalidArgumentException("O campo 'name' é obrigatório.");
        }
        $this->name       = $data['name'];
        $this->email      = $data['email']      ?? null;
        $this->createdAt  = $data['created_at'] ?? null;
        $this->updatedAt  = $data['updated_at'] ?? null;
        $this->deletedAt  = $data['deleted_at'] ?? null;
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getEmail(): ?string { return $this->email; }
    public function getCreatedAt(): ?string { return $this->createdAt; }
    public function getUpdatedAt(): ?string { return $this->updatedAt; }
    public function getDeletedAt(): ?string { return $this->deletedAt; }

    // Setters
    public function setName(string $name): void { $this->name = $name; }
    public function setEmail(?string $email): void { $this->email = $email; }
    public function setDeletedAt(?string $deletedAt): void { $this->deletedAt = $deletedAt; }

    // Example of domain behavior
    public function isDeleted(): bool
    {
        return !is_null($this->deletedAt);
    }

    public function formatName(): string
    {
        return ucwords(strtolower($this->name));
    }
}
