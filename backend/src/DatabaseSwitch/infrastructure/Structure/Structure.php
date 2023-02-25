<?php

namespace App\DatabaseSwitch\infrastructure\Structure;


use Symfony\Component\Serializer\Exception\RuntimeException;

class Structure
{

    private array $structures = [];
    /**
     * @param array<StructureInterface> $structures
     */
    public function __construct(array $structures = [])
    {
        $this->structures = $structures;
    }


    /**
     * {@inheritdoc}
     */
    public function supportsStructure(string $database): bool
    {
        try {
            $this->getStructure($database);
        } catch (RuntimeException) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getStructure(string $database): StructureInterface
    {
       foreach ($this->structures as $structure){
           if($structure->support($database)){
               return  $structure;
           }
       }
       throw new RuntimeException(sprintf('No structure found for database "%s".', $database));
    }

}
