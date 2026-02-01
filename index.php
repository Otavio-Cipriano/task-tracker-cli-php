<?php

$args = array_slice($argv, 1);
$cmd = $args[0] ?? 'help';
$filename = 'data.json';
$data = '';

if(!file_exists("data.json")){
    $file = fopen($filename, 'a+');
    fwrite($file, "[]");
    fclose($file);
}

$file = fopen($filename, "r");
$data = json_decode(fread($file,filesize($filename)));
fclose($file);


switch ($cmd){
    case 'help':
        echo "Only valid commands: add, list, update, mark, delete";
        break;
    case 'list':
        showTasks($data);
        break;
    case 'add':
        if (!isset($args[1])) {
            echo "No description was provided";
            break;
        }
        $status = $args[2] ?? 'todo';
        addTask($data, $filename, $args[1], $status);
        break;
    case 'mark-done':
        if(!isset($args[1])){
            echo "No id was provided";
            break;
        }
        mark($data, $filename, $args[1], 'done');
        break;
}

function mark(array $tasks, string $filename, int $id, string $status): void
{
    $task = array_filter($tasks, fn($var)=> $var->id == $id);
    $task = $task->status = $status;
    print_r($task);
}

function addTask(array $tasks, string $filename, string $description, string $status): void
{
    $tasks[] = createTask(
        generateId($tasks),
        $description,
        $status
    );

    file_put_contents(
        $filename,
        json_encode($tasks, JSON_PRETTY_PRINT)
    );

    echo "Task added successfully";
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

function showTasks($tasks): void
{
    foreach ($tasks as $task){
        echo "\n". $task->id . "# ".$task->description." | ".$task->status;
    }
}

function generateId(array $tasks): int
{
    if (empty($tasks)) {
        return 1;
    }

    $lastTask = end($tasks);

    return $lastTask->id + 1;
}