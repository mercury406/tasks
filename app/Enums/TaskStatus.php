<?php

namespace App\Enums;

enum TaskStatus: int
{
    case Created = 0;
    case Pending = 1;
    case Completed = 2;
    case Cancelled = 100;

}
