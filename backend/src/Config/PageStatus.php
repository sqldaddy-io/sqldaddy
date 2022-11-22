<?php

namespace App\Config;

enum PageStatus:string
{
    case PENDING = 'Pending';
    case IN_PROGRESS = 'In progress';
    case COMPLETED_ERROR = 'Completed with error';
    case COMPLETED_SUCCESS = 'Completed successfully';
}
