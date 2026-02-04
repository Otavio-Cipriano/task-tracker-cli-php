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

    public function addTask(string $description, TaskStatus $status)
    {
        $task = $this->createTask($this->generateId($this->tasks), $description, $status);

        $this->tasks[] = $task;

        $this->fileManager->writeFile($this->tasks);

        echo "Task created succesfully ";

    }
    public function listTasks()
    {

    }
    public function deleteTask()
    {

    }
    public function markTask()
    {

    }
    public function updateTask()
    {

    }

    public function help(){
        echo "Only valid commands: add, list, update, mark, delete";
    }

    function createTask($id, $desc, $status): object
    {
        return (object) [
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