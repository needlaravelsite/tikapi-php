<?php

namespace NeedLaravelSite\TikApi\Client;

use GuzzleHttp\ClientInterface;
use NeedLaravelSite\TikApi\Exceptions\TikApiException;
use Throwable;

class HttpClient
{
    protected ClientInterface $http;
    protected string $apiKey;
    protected ?string $accountKey;
    protected string $baseUrl;

    public function __construct(ClientInterface $http, string $apiKey, ?string $accountKey = null, string $baseUrl = 'https://api.tikapi.io')
    {
        $this->http = $http;
        $this->apiKey = $apiKey;
        $this->accountKey = $accountKey;
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    /**
     * @throws TikApiException
     */
    public function request(string $method, string $path, array $query = [], array $json = []): array
    {
        try {
            $headers = [
                'Accept' => 'application/json',
                'X-API-KEY' => $this->apiKey,
            ];

            if ($this->accountKey) $headers['X-ACCOUNT-KEY'] = $this->accountKey;

            $response = $this->http->request($method, $this->baseUrl . '/' . ltrim($path, '/'), [
                'headers' => $headers,
                'query' => $query,
                'json' => $json ?: null,
            ]);

            return json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable $e) {
            throw new TikApiException('TikAPI request failed: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }
}