<?php

namespace App\Core;

class TaskService
{
    private FileManager $fileManager;

    private array $tasks;

    public function __construct(FileManager $fileManager, array $tasks)
    {
        $this->fileManager = $fileManager;
        $this->tasks = $tasks;
    }

    public function addTask(string $description, TaskStatus $status): void
    {
        $task = $this->createTask($this->generateId($this->tasks), $description, $status);

        $this->tasks[] = $task;

        $this->fileManager->writeFile($this->tasks);

        echo "Task created succesfully ";

    }

    public function listTasks(?TaskStatus $status): array
    {
        if (count($this->tasks) < 1) {
            echo "No tasks";
            return [];
        }

        if ($status != null) {
            print_r(array_filter(
                $this->tasks,
                fn($task) => $task->status === $status));
            return array_filter(
                $this->tasks,
                fn($task) => $task->status === $status);
        }

        print_r($this->tasks);
        return $this->tasks;
    }

    public function deleteTask(int $id): void
    {
        $found = false;
        for ($i = 0; $i < count($this->tasks); $i++) {
            if ($this->tasks[$i]->id === $id) {
                array_splice($this->tasks, $i, 1);
                $found = true;
                break;
            }
        }

        if (!$found) {
            echo "No task corresponded to that id";
            return;
        }

        $this->fileManager->writeFile($this->tasks);
        echo "Task $id deleted successfully";
    }

    public function markTask(int $id, TaskStatus $status)
    {
        $count = count($this->tasks);
        for ($i = 0; $i<$count; $i++){
            if($this->tasks[$i]->id == $id){
                $this->tasks[$i]->status = $status;
                $this->tasks[$i]->updated_at = date("Y-m-d H:i:s");
            }
        }

        $this->fileManager->writeFile($this->tasks);
        echo "Task $id marked successfully";
    }

    public function updateTask(int $id, string $description, ?TaskStatus $status): void
    {
        $count = count($this->tasks);
        for ($i = 0; $i<$count; $i++){
            if($this->tasks[$i]->id == $id){
                $this->tasks[$i]->status = $status?? $this->tasks[$i]->status;
                $this->tasks[$i]->description = $description;
                $this->tasks[$i]->updated_at = date("Y-m-d H:i:s");
            }
        }

        $this->fileManager->writeFile($this->tasks);
        echo "Task $id updated successfully";
    }


    function createTask($id, $desc, $status): object
    {
        return (object)[
            'id' => $id,
            'description' => $desc,
            'status' => $status,
            'updated_at' => '',
            "created_at" => date("Y-m-d H:i:s")
        ];
    }

    function generateId(array $tasks): int
    {
        if (empty($tasks)) {
            return 1;
        }

        $lastTask = end($tasks);

        return $lastTask->id + 1;
    }
}