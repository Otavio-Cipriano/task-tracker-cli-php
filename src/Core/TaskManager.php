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

        $this->taskService->listTasks($args[0]);
        return [];
    }
    function mark(array $args) {
        if(!isset($args[0])){
            echo "No id provided";
            return null;
        }
        $status = TaskStatus::tryFrom($args[1]);
        $this->taskService->markTask($args[0],$status);
    }
    function update(array $args) {}
    function delete(array $args) {}

    public function help(): void {
        echo "Only valid commands: add, list, update, mark, delete";
    }
}