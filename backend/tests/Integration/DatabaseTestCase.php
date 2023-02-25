<?php

namespace App\Tests\Integration;

use App\SandBox\Domain\Entity\Database;
use App\SandBox\Domain\Entity\DatabaseVersion;
use App\SandBox\Domain\Entity\Page;
use App\SandBox\Domain\Entity\Script;
use App\SandBox\infrastructure\Service\UrlGenerate;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class DatabaseTestCase extends KernelTestCase
{

    protected ContainerInterface $container;
    protected EntityManager $entityManager;
    protected Page $page;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();

        $this->container = static::getContainer();
        $this->entityManager = $this->container->get('doctrine')->getManager();
        $database = $this->entityManager->getRepository(Database::class)->findOneBy(['name' => 'PostgreSQL']);
        $databaseVersion = $this->entityManager->getRepository(DatabaseVersion::class)->findOneBy(['name' => '15', 'database' => $database]);

        /** @var UrlGenerate $urlGenerate */
        $urlGenerate = $this->container->get(UrlGenerate::class);

        $this->page = new Page();
        $this->page->setDatabaseVersion($databaseVersion);
        $this->page->setPath($urlGenerate());
        $script = new Script();
        $script->setRequest('select version();');
        $this->page->addScript($script);
    }

}
