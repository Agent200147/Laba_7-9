<?php

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Repository\UserRepository;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

use Symfony\Component\BrowserKit;

class ApiTest extends ApiTestCase
{
    public function apiToken(): string
    {
        $user = static::getContainer()->get(UserRepository::class)->findOneBy(['email' => 'qqqqqq@mail.ru']);
        return $user->getApiToken();
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function testComments(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/comments');
        $this->assertResponseStatusCodeSame(401);

        $response = $client->withOptions([
            'headers' => ['x-auth-token' => $this->apiToken(), 'content-type' => 'application/json; charset=utf-8'],
        ])->request('GET', '/api/comments');
        $this->assertResponseStatusCodeSame(200);

        $this->assertJson($response->getContent());
        $resultArray = $response->toArray();
        $this->assertIsArray($resultArray);
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function testNews(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/news');
        $this->assertResponseStatusCodeSame(401);

        $response = $client->withOptions([
            'headers' => ['x-auth-token' => $this->apiToken(), 'content-type' => 'application/json; charset=utf-8'],
        ])->request('GET', '/api/news');
        $this->assertResponseStatusCodeSame(200);

        $this->assertJson($response->getContent());
        $resultArray = $response->toArray();
        $this->assertIsArray($resultArray);
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function testUsers(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/users');
        $this->assertResponseStatusCodeSame(401);

        $response = $client->withOptions([
            'headers' => ['x-auth-token' => $this->apiToken(), 'content-type' => 'application/json; charset=utf-8'],
        ])->request('GET', '/api/users');
        $this->assertResponseStatusCodeSame(200);

        $this->assertJson($response->getContent());
        $resultArray = $response->toArray();
        $this->assertIsArray($resultArray);
    }



}
