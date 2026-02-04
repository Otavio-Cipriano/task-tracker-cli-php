<?php

namespace App\Cli;

use App\Core\TaskManager;
use App\Core\TaskService;

class CommandDispatcher
{
    private TaskManager $taskManager;

    function __construct(TaskManager $taskManager)
    {
        $this->taskManager = $taskManager;
    }

    private function commandHandler(): array {
        return [
            'add' => fn($args)=> $this->taskManager->add($args)
        ];
    }

    public function run(array $args, string $command): void
    {
        $commands = $this->commandHandler();
        $handler = $commands[$command];
        $handler($args);
    }
}