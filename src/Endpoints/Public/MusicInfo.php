<?php

namespace NeedLaravelSite\TikApi\Endpoints\Public;

use NeedLaravelSite\TikApi\Client\HttpClient;
use NeedLaravelSite\TikApi\Exceptions\TikApiException;

/**
 * TikAPI Public Endpoint: /public/music/info
 *
 * Retrieve detailed information about a specific TikTok music (sound).
 *
 * @example
 * $tikapi->public()->musicInfo()->get('28459463');
 */
class MusicInfo
{
    protected HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Get information about a TikTok music (sound).
     *
     * @param string $id TikTok music ID or short TikTok link.
     * @param string|null $country Optional ISO code (e.g., 'us', 'ca', 'gb').
     *
     * @return array TikAPI JSON response.
     * @throws TikApiException
     */
    public function get(string $id, ?string $country = null): array
    {
        $params = ['id' => $id];

        if ($country) {
            $params['country'] = $country;
        }

        return $this->http->request('GET', 'public/music/info', $params);
    }
}
