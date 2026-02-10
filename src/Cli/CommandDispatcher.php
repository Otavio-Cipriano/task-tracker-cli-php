<?php

namespace App\Cli;

use App\Core\TaskManager;

class CommandDispatcher
{
    private TaskManager $taskManager;

    function __construct(TaskManager $taskManager)
    {
        $this->taskManager = $taskManager;
    }

    private function commandHandler(): array {
        return [
            'add' => fn($args)=> $this->taskManager->add($args),
            'list' => fn($args)=> $this->taskManager->list($args),
            'mark-todo' => fn($args)=>$this->taskManager->mark([...$args, 'todo']),
            'mark-done' => fn($args)=>$this->taskManager->mark([...$args, 'done']),
            'mark-in-progress' => fn($args)=>$this->taskManager->mark([...$args, 'in-progress']),
            'delete' => fn($args) => $this->taskManager->delete($args),
            'update' => fn($args) => $this->taskManager->update($args),
            'help' => fn($args) => $this->taskManager->help()
        ];
    }

    public function run(array $args, string $command): void
    {
        $commands = $this->commandHandler();
        $handler = $commands[$command];
        $handler($args);
    }
}