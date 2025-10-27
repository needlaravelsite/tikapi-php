<?php

namespace NeedLaravelSite\TikApi\Endpoints\Public;

use NeedLaravelSite\TikApi\Client\HttpClient;
use NeedLaravelSite\TikApi\Exceptions\TikApiException;

/**
 * TikAPI Public Endpoint: /public/following
 *
 * Retrieve the following list of a TikTok user by their secUid.
 *
 * @example
 * $tikapi->public()->following()->list('MS4wLjABAAAAsHntXC3...');
 */
class Following
{
    protected HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Fetch following accounts for a TikTok user by secUid.
     *
     * @param string $secUid
     * @param int|null $count
     * @param int|null $nextCursor
     * @param string|null $country
     *
     * @return array TikAPI JSON response
     * @throws TikApiException
     */
    public function list(
        string $secUid,
        ?int $count = 30,
        ?int $nextCursor = null,
        ?string $country = null
    ): array {
        $params = [
            'secUid' => $secUid,
            'count' => $count,
        ];

        if ($nextCursor !== null) {
            $params['nextCursor'] = $nextCursor;
        }

        if ($country) {
            $params['country'] = $country;
        }

        return $this->http->request('GET', 'public/following', $params);
    }
}
