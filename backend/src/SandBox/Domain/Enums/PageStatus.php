<?php

namespace App\SandBox\Domain\Enums;

enum PageStatus:string
{
    case CREATED = 'Created';
    case PENDING = 'Pending';
    case IN_PROGRESS = 'In progress';
    case COMPLETED_ERROR = 'Completed with error';
    case COMPLETED_SUCCESS = 'Completed successfully';
}
