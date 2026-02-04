<?php

namespace App\Core;

class TaskManager
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    //TODO: Alterar o parametro para enum status novamente.
    //TODO: Alterar o controler, não deve criar a task e nem ter regra de negócio.
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

        $this->taskService->addTask($description, $status);

        return [];
    }


}