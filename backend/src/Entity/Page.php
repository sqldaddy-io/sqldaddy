<?php

namespace App\Entity;


use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Config\PageStatus;
use App\Repository\PageRepository;
use App\State\PagePostProcessor;
use App\State\PagePutProcessor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PageRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new Post(processor: PagePostProcessor::class),
        new Put(processor: PagePutProcessor::class),
    ],
    normalizationContext: ['groups' => ['page_read']],
    denormalizationContext: ['groups' => ['page_write']],
    paginationEnabled: false
)]
class Page
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ApiProperty(identifier: false)]
    #[Groups(['page_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['page_read'])]
    #[ApiProperty(identifier: true)]
    private ?string $path = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\ManyToOne(cascade: ['persist','remove'], fetch: "EAGER")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['page_read', 'page_write'])]
    private ?DatabaseVersion $databaseVersion = null;

    #[ORM\OneToMany(mappedBy: 'page', targetEntity: Script::class, cascade: ['persist'])]
    #[Groups(['page_read', 'page_write'])]
    private Collection $scripts;

    #[ORM\Column]
    #[Groups(['page_read'])]
    private PageStatus $status = PageStatus::PENDING;


//
//    public function __clone()
//    {
//        if ($this->id or $this->path) {
//            $this->id = null;
//            $this->path = null;
//            $mClone = new ArrayCollection();
//            foreach ($this->scripts as $item) {
//                $itemClone = clone $item;
//                $itemClone->setPage($this);
//                $mClone->add($itemClone);
//            }
//            $this->scripts = $mClone;
//        }
//    }




    public function __construct()
    {
        $this->scripts = new ArrayCollection();
        $this->createAt = new \DateTimeImmutable('now');
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

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getDatabaseVersion(): ?DatabaseVersion
    {
        return $this->databaseVersion;
    }

    public function setDatabaseVersion(?DatabaseVersion $databaseVersion): self
    {
        $this->databaseVersion = $databaseVersion;

        return $this;
    }

    /**
     * @return Collection<int, Script>
     */
    public function getScripts(): Collection
    {
        return $this->scripts;
    }

    /**
     * @param Collection $scripts
     */
    public function setScripts(Collection $scripts): void
    {
        $this->scripts = $scripts;
    }

    public function addScript(Script $script): self
    {
        if (!$this->scripts->contains($script)) {
            $this->scripts->add($script);
            $script->setPage($this);
        }

        return $this;
    }

    public function removeScript(Script $script): self
    {
        if ($this->scripts->removeElement($script)) {
            // set the owning side to null (unless already changed)
            if ($script->getPage() === $this) {
                $script->setPage(null);
            }
        }

        return $this;
    }

    /**
     * @return PageStatus
     */
    public function getStatus(): PageStatus
    {
        return $this->status;
    }

    /**
     * @param PageStatus $status
     */
    public function setStatus(PageStatus $status): void
    {
        $this->status = $status;
    }


}
