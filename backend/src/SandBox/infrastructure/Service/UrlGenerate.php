<?php

namespace App\SandBox\infrastructure\Service;

use Ramsey\Uuid\Uuid;

class UrlGenerate
{
    public function __invoke(): string
    {
        return hash('adler32', Uuid::uuid4());
    }
}
