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
        addTask($data,$filename,$args[1], $args[2]);

}

function addTask($tasks, $filename, $description, $status): void
{
    if(!isset($description)) {
        echo "Description was not provided";
        return;
    }
    $status = $status ?? 'todo';
    $tasks = [...$tasks, createTask(generateId($tasks), $description, $status)];
    $file = fopen($filename, "w");
    fwrite($file, json_encode($tasks, JSON_PRETTY_PRINT));
    fclose($file);
    echo "Task added succesfully";
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
        echo "\n| 1 | ".$task->description." | ".$task->status." |\n";
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