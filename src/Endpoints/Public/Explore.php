<?php

namespace NeedLaravelSite\TikApi\Endpoints\Public;

use NeedLaravelSite\TikApi\Client\HttpClient;
use NeedLaravelSite\TikApi\Exceptions\TikApiException;

/**
 * TikAPI Public Endpoint: /public/explore
 *
 * Retrieve trending or recommended TikTok posts ("For You" section).
 *
 * @example
 * $tikapi->public()->explore()->list();
 */
class Explore
{
    protected HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Fetch trending posts from TikTok's explore feed.
     *
     * @param int|null $count
     * @param string|null $country
     *
     * @return array TikAPI JSON response
     * @throws TikApiException
     */
    public function list(?int $count = 30, ?string $country = null): array
    {
        $params = [
            'count' => $count,
        ];

        if ($country) {
            $params['country'] = $country;
        }

        return $this->http->request('GET', 'public/explore', $params);
    }
}
