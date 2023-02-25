<?php

namespace App\SandBox\Domain\Entity;

use App\SandBox\infrastructure\Repository\DatabaseParamRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DatabaseParamRepository::class)]
class DatabaseParam
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    private ?string $driver = null;

    #[ORM\Column(length: 255)]
    private ?string $host = null;

    #[ORM\Column]
    private ?int $port = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;


    #[ORM\Column(length: 255)]
    private ?string $serverVersion = null;

    #[ORM\Column(length: 255)]
    private ?string $charset = null;

    #[ORM\Column(length: 255)]
    private ?string $containerName = null;

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getConnectionParam($dbname = null, $username = null, $password = null): array
    {
        $dns = match ($this->getDriver()) {
            'sqlsrv' =>  "sqlsrv:Server={host};database={dbname};",
            default => '{driver}:host={host};port={port};'.(($dbname)?'dbname={dbname};':null)
        };
        return [
            'dns' => strtr($dns, [
                '{driver}' => $this->getDriver(),
                '{host}' => $this->getHost(),
                '{port}' => $this->getPort(),
                '{dbname}' => $dbname,
            ]),
            'user' => $username ?? $this->getUsername(),
            'password' => $password ?? $this->getPassword(),
        ];
    }



    public function getDriver(): ?string
    {
        return $this->driver;
    }

    public function setDriver(string $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    public function getHost(): ?string
    {
        return $this->host;
    }

    public function setHost(string $host): self
    {
        $this->host = $host;

        return $this;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function setPort(int $port): self
    {
        $this->port = $port;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }



    public function getServerVersion(): ?string
    {
        return $this->serverVersion;
    }

    public function setServerVersion(string $serverVersion): self
    {
        $this->serverVersion = $serverVersion;

        return $this;
    }

    public function getCharset(): ?string
    {
        return $this->charset;
    }

    public function setCharset(string $charset): self
    {
        $this->charset = $charset;

        return $this;
    }

    public function getContainerName(): ?string
    {
        return $this->containerName;
    }

    public function setContainerName(string $containerName): self
    {
        $this->containerName = $containerName;

        return $this;
    }
}
