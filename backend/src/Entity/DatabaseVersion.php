<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Repository\DatabaseVersionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DatabaseVersionRepository::class)]
#[ApiResource(
    operations: [
        new Get()
    ],
    paginationEnabled: false
)]
class DatabaseVersion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['database_read', 'page_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['database_read', 'page_read'])]
    private ?string $name = null;


    #[ORM\ManyToOne(targetEntity: Database::class, fetch: "EAGER", inversedBy: 'versions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['page_read'])]
    private ?Database $database = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?DatabaseParam $param = null;

    #[ORM\Column]
    private ?int $sort = null;

    public function __toString(): string
    {
        return $this->database->getName().$this->getName();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


    public function getDatabase(): ?Database
    {
        return $this->database;
    }

    public function setDatabase(?Database $database): self
    {
        $this->database = $database;

        return $this;
    }

    public function getParam(): ?DatabaseParam
    {
        return $this->param;
    }

    public function setParam(?DatabaseParam $param): self
    {
        $this->param = $param;

        return $this;
    }

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(int $sort): self
    {
        $this->sort = $sort;

        return $this;
    }
}
