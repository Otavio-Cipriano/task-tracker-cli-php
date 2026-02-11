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

    public function create(string $description, TaskStatus $status): Task
    {
        $sql = "INSERT INTO tasks (description, status) VALUES (:description, :status)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
                'description' => $description,
                'status' => $status->value
        ]);

        $id = (int) $this->pdo->lastInsertId();

        return new Task($id, $description, $status);
    }

    //TODO: Return the tasks created

    public function findByStatus(TaskStatus $status): array{
        $sql = "SELECT * FROM tasks WHERE (status == :status)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'status' => $status->value
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAll(): array{
        $stmt = $this->pdo->query("SELECT * FROM tasks");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(int $id, string $description, ?TaskStatus $status): bool
    {
        $sql = "UPDATE tasks SET description = :description";

        $params = [
            'description' => $description,
            'id' => $id
        ];

        //check if status is null, editing string $sql adding the status
        //Adding the field status in params
        if ($status !== null) {
            $sql .= ", status = :status";
            $params['status'] = $status->value;
        }

        $sql .= " WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->rowCount() > 0;
    }

    public function updateStatus(int $id, TaskStatus $status): bool
    {
        $sql = "UPDATE tasks SET status = :status WHERE id = :id";

        $params = [
            'status' => $status->value,
            'id' => $id
        ];

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM tasks WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->rowCount() > 0;
    }

}