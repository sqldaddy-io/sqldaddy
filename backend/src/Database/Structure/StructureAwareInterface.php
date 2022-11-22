<?php

namespace App\Database\Structure;


interface StructureAwareInterface
{
    public function get(string $database):StructureInterface;
}
