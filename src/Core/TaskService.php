<?php

namespace App\Core;

class TaskService
{
//    private FileManager $fileManager;

    private TaskRepository $taskRepository;

    public function __construct()
    {
        $this->taskRepository = new TaskRepository();
    }

    public function addTask(string $description, TaskStatus $status): void
    {
        $this->taskRepository->create($description, $status);
        echo "Task created succesfully ";

    }

    public function listTasks(?TaskStatus $status): array
    {
        if($status != null){
            $tasks = $this->taskRepository->findByStatus($status);
            print_r($tasks);
            return [];
        }
        $tasks = $this->taskRepository->findAll();
        print_r($tasks);
        return [];
    }

    public function deleteTask(int $id): void
    {
        $this->taskRepository->delete($id);
        echo "Task $id deleted successfully";
    }

    public function markTask(int $id, TaskStatus $status)
    {
        $this->taskRepository->updateStatus($id, status: $status);
        echo "Task $id marked successfully";
    }

    public function updateTask(int $id, string $description, ?TaskStatus $status): void
    {
        $this->taskRepository->update($id, $description, $status);
        echo "Task $id updated successfully";
    }
}