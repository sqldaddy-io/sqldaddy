<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Action\StatisticController;
use App\Repository\DatabaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DatabaseRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new GetCollection(
            uriTemplate: '/statistics',controller: StatisticController::class
        )
    ],
    normalizationContext: ['groups'=>['database_read']],
    order: ['sort' => 'ASC'],
    paginationEnabled: false
)]
class Database implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    #[Groups(['database_read', 'page_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['database_read', 'page_read'])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'database', targetEntity: DatabaseVersion::class, cascade: ["persist", "remove"], orphanRemoval: true)]
    #[Groups(['database_read'])]
    #[ORM\OrderBy(['sort' => 'ASC'])]
    private Collection $versions;

    #[ORM\Column]
    private ?int $sort = null;


    public function __construct()
    {
        $this->versions = new ArrayCollection();
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

    /**
     * @return Collection<int, DatabaseVersion>
     */
    public function getVersions(): Collection
    {
        return $this->versions;
    }

    public function addVersion(DatabaseVersion $version): self
    {
        if (!$this->versions->contains($version)) {
            $this->versions->add($version);
            $version->setDatabase($this);
        }

        return $this;
    }

    public function removeVersion(DatabaseVersion $version): self
    {
        if ($this->versions->removeElement($version)) {
            // set the owning side to null (unless already changed)
            if ($version->getDatabase() === $this) {
                $version->setDatabase(null);
            }
        }

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


    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
        ];
    }
}
