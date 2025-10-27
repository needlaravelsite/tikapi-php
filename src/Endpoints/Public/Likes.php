<?php

namespace NeedLaravelSite\TikApi\Endpoints\Public;

use NeedLaravelSite\TikApi\Client\HttpClient;
use NeedLaravelSite\TikApi\Exceptions\TikApiException;

/**
 * TikAPI Public Endpoint: /public/likes
 *
 * Retrieve the list of liked TikTok videos for a user by their secUid.
 *
 * @example
 * $tikapi->public()->likes()->list('MS4wLjABAAAAsHntXC3...');
 */
class Likes
{
    protected HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Fetch liked videos for a TikTok user by secUid.
     *
     * @param string $secUid
     * @param int|null $count
     * @param string|null $cursor
     * @param string|null $country
     *
     * @return array TikAPI JSON response
     * @throws TikApiException
     */
    public function list(
        string $secUid,
        ?int $count = 30,
        ?string $cursor = null,
        ?string $country = null
    ): array {
        $params = [
            'secUid' => $secUid,
            'count' => $count,
        ];

        if ($cursor) $params['cursor'] = $cursor;
        if ($country) $params['country'] = $country;

        return $this->http->request('GET', 'public/likes', $params);
    }
}
