<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\TaskManager;
use App\Core\TaskService;
use App\Cli\CommandDispatcher;
use App\Core\FileManager;



$taskService = new TaskService();
$taskManager = new TaskManager($taskService);
$cli = new CommandDispatcher($taskManager);

$args = array_slice($argv, 1);
$cmd = $args[0] ?? 'help';
$cli->run(array_slice($args, 1), $cmd);