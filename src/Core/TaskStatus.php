<?php

namespace App\Core;

enum TaskStatus: string
{
    case TODO = 'todo';
    case INPROGRESS = 'in-progress';
    case DONE = 'done';


    static public function existsStatus(string $value): bool
    {
        if (array_any(TaskStatus::cases(), fn($status) => $status == $value)) {
            return true;
        }

        return false;
    }

}