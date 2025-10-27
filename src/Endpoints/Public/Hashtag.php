<?php

namespace NeedLaravelSite\TikApi\Endpoints\Public;

use NeedLaravelSite\TikApi\Client\HttpClient;
use NeedLaravelSite\TikApi\Exceptions\TikApiException;

/**
 * TikAPI Public Endpoint: /public/hashtag
 *
 * Retrieve TikTok posts associated with a hashtag by name or ID.
 *
 * @example
 * $tikapi->public()->hashtag()->list(name: 'funny');
 * $tikapi->public()->hashtag()->list(id: '4655293');
 */
class Hashtag
{
    protected HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Fetch posts for a TikTok hashtag by name or ID.
     *
     * @param string|null $name The hashtag name (used on first request)
     * @param string|null $id The hashtag ID
     * @param int|null $count Number of posts to retrieve (max 30)
     * @param string|null $cursor Pagination cursor (used for pagination)
     * @param string|null $country Optional ISO country code (e.g. 'us', 'ca')
     *
     * @return array TikAPI JSON response
     * @throws TikApiException
     */
    public function list(
        ?string $name = null,
        ?string $id = null,
        ?int $count = 30,
        ?string $cursor = null,
        ?string $country = null
    ): array {
        if (!$name && !$id) {
            throw new TikApiException('Either "name" or "id" must be provided for /public/hashtag');
        }

        $params = ['count' => $count];

        if ($name) $params['name'] = $name;
        if ($id) $params['id'] = $id;
        if ($cursor) $params['cursor'] = $cursor;
        if ($country) $params['country'] = $country;

        return $this->http->request('GET', 'public/hashtag', $params);
    }
}
