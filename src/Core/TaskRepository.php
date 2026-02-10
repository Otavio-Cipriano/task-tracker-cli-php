<?php

namespace App\Core;

use App\Database\Connection;
use PDO;

class TaskRepository
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::get();
    }

    public function create(string $description, TaskStatus $status)
    {
        $sql = "INSERT INTO tasks (description, status) VALUES (:description, :status)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
                'description' => $description,
                'status' => $status->value
        ]);
    }
}

//TODO: Precisa criar um model para task
//TODO: alterar a logica posteriormente para usar o model task
