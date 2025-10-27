<?php

namespace NeedLaravelSite\TikApi\Endpoints\Public;

use NeedLaravelSite\TikApi\Client\HttpClient;
use NeedLaravelSite\TikApi\Exceptions\TikApiException;

/**
 * TikAPI Public Endpoint: /public/music
 *
 * Retrieve TikTok posts that use a specific music ID or sound link.
 *
 * @example
 * $tikapi->public()->music()->list('28459463');
 */
class Music
{
    protected HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Fetch posts using a specific TikTok music (sound).
     *
     * @param string $id Music ID or short TikTok music link.
     * @param int|null $count Number of posts to fetch (max 30).
     * @param string|null $cursor Pagination cursor for next results.
     * @param string|null $country Optional ISO code (e.g., 'us', 'ca', 'gb').
     *
     * @return array TikAPI JSON response.
     * @throws TikApiException
     */
    public function list(
        string $id,
        ?int $count = 30,
        ?string $cursor = null,
        ?string $country = null
    ): array {
        $params = [
            'id' => $id,
            'count' => $count,
        ];

        if ($cursor) {
            $params['cursor'] = $cursor;
        }

        if ($country) {
            $params['country'] = $country;
        }

        return $this->http->request('GET', 'public/music', $params);
    }
}
