<?php

namespace NeedLaravelSite\TikApi\Endpoints\Public;

use NeedLaravelSite\TikApi\Client\HttpClient;
use NeedLaravelSite\TikApi\Exceptions\TikApiException;

class Check
{
    /**
     * The HTTP transport instance.
     */
    protected HttpClient $http;

    /**
     * Create a new Check endpoint instance.
     *
     * @param HttpClient $http
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Verify a TikTok username or API connectivity.
     *
     * Example:
     * $tikapi->public()->check()->username('lilyachty');
     *
     * @param string $username TikTok username to verify
     * @return array TikAPI response payload
     *
     * @throws TikApiException
     */
    public function username(string $username): array
    {
        return $this->http->request('GET', 'public/check', [
            'username' => $username,
        ]);
    }
}
