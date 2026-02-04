<?php

namespace App\Core;

enum TaskStatus: string
{
    case TODO = 'todo';
    case INPROGRESS = 'in-progress';
    case DONE = 'done';
}