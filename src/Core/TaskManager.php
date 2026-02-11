<?php

namespace App\Core;

class TaskManager
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    function add(array $args): ?array
    {
        $description = $args[0] ?? null;

        if (!$description) {
            echo "Description required";
            return null;
        }

        if (!isset($args[1])) {
            $status = TaskStatus::TODO;
        } else {
            $status = TaskStatus::tryFrom($args[1]);

            if ($status === null) {
                echo "Invalid status";
                return null;
            }
        }

        $this->taskService->addTask($description, $status);

        return [];
    }

    function list(array $args): array {
        if(!isset($args[0])){
            $this->taskService->listTasks(null);
            return [];
        }

        $status = TaskStatus::tryFrom($args[0]);

        if ($status === null) {
            echo "Invalid Status";
            return [];
        }

        return $this->taskService->listTasks($status);
    }
    function mark(array $args) {
        if(!isset($args[0])){
            echo "No id provided";
            return null;
        }
        $status = TaskStatus::tryFrom($args[1]);
        $this->taskService->markTask($args[0],$status);
    }
    function update(array $args) {

        if (!isset($args[0])) {
            echo "No id provided";
            return null;
        }

        if (!isset($args[1])) {
            echo "No description provided";
            return null;
        }

        $status = null;

        if (isset($args[2])) {
            $status = TaskStatus::tryFrom($args[2]);

            if ($status === null) {
                echo "Invalid status";
                return null;
            }
        }

        $id = (int) $args[0];

        $this->taskService->updateTask($id, $args[1], $status);
    }
    function delete(array $args) {
        if (!isset($args[0])) {
            echo "No id provided";
            return null;
        }

        $id = (int) $args[0];
        $this->taskService->deleteTask($id);
    }

    public function help(): void {
        echo "Only valid commands: add, list, update, mark, delete";
    }
}