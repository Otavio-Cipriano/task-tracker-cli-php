<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\TaskManager;
use App\Core\TaskService;
use App\Cli\CommandDispatcher;
use App\Core\FileManager;

$filename = 'src/data.json';
$fileManager = new FileManager($filename);

$tasks = $fileManager->loadFile();

$taskService = new TaskService($fileManager,$tasks);
$taskManager = new TaskManager($taskService);
$cli = new CommandDispatcher($taskManager);

$args = array_slice($argv, 1);
$cmd = $args[0] ?? 'help';
$cli->run(array_slice($args, 1), $cmd);