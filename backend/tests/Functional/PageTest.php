<?php

namespace App\Tests\Functional;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\SandBox\Domain\Entity\DatabaseVersion;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class PageTest extends ApiTestCase
{

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testCreatePage()
    {
        $response = static::createClient()->request('POST', '/api/pages', [
            'json' => [
                'databaseVersion' => $this->findIriBy(DatabaseVersion::class, ['name' => '15']),
                'scripts' => [
                    [
                        'request' => 'select version();'
                    ]
                ]
            ]
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertNotEmpty($response->toArray()['@id']);
    }

}
