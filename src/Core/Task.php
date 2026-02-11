<?php

namespace App\Core;

class Task
{
    private int $id;
    private string $description;
    private TaskStatus $status;
    public function __construct(int $id, string $description, TaskStatus $status)
    {
        $this->id = $id;
        $this->description = $description;
        $this->status = $status;
    }
}