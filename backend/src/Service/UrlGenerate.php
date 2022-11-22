<?php

namespace App\Service;

use Ramsey\Uuid\Uuid;

class UrlGenerate
{
    public function __invoke(): string
    {
        return hash('adler32', Uuid::uuid4());
    }
}
