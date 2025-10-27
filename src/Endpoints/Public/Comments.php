<?php

namespace NeedLaravelSite\TikApi\Endpoints\Public;

use NeedLaravelSite\TikApi\Client\HttpClient;
use NeedLaravelSite\TikApi\Exceptions\TikApiException;

/**
 * TikAPI Public Endpoint: /public/comment/list
 *
 * Retrieve the comments list for a specific TikTok video.
 *
 * @example
 * $tikapi->public()->comments()->list('7109178205151464746');
 */
class Comments
{
    protected HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Fetch comments for a TikTok video.
     *
     * @param string $mediaId  TikTok video ID or short link.
     * @param int|null $count  Number of comments to return (max 30).
     * @param int|null $cursor Pagination cursor (returned in previous response).
     * @param string|null $country ISO country code (e.g. 'us', 'ca').
     * @param int|null $sessionId Optional session ID for longer sessions.
     *
     * @return array TikAPI JSON response.
     * @throws TikApiException
     */
    public function list(
        string $mediaId,
        ?int $count = 30,
        ?int $cursor = null,
        ?string $country = null,
        ?int $sessionId = null
    ): array {
        $params = [
            'media_id' => $mediaId,
            'count' => $count,
        ];

        if ($cursor !== null) {
            $params['cursor'] = $cursor;
        }

        if ($country) {
            $params['country'] = $country;
        }

        if ($sessionId !== null) {
            $params['session_id'] = $sessionId;
        }

        return $this->http->request('GET', 'public/comment/list', $params);
    }
}
