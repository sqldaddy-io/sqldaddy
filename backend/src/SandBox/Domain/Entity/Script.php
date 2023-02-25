<?php

namespace App\SandBox\Domain\Entity;

use App\SandBox\infrastructure\Repository\ScriptRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ScriptRepository::class)]
class Script
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['page_read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['page_read', 'page_write'])]
    private ?string $request = null;


    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'scripts')]
    private ?Page $page = null;

    #[ORM\Column]
    #[Groups(['page_read'])]
    private array $response = [];

    #[ORM\Column(options: ['default' => 0])]
    #[Groups(['page_read', 'page_write'])]
    private int $sort = 0;

    public function __clone()
    {
        if($this->id){
            $this->id = null;
            $this->page = null;
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }




    public function getRequest(): ?string
    {
        return $this->request;
    }

    public function setRequest(string $request): self
    {
        $this->request = $request;

        return $this;
    }



    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getResponse(): array
    {
        return $this->response;
    }

    public function setResponse(array $response): self
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return int
     */
    public function getSort(): int
    {
        return $this->sort;
    }

    /**
     * @param int $sort
     */
    public function setSort(int $sort): void
    {
        $this->sort = $sort;
    }



}
