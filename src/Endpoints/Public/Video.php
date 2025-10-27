<?php

namespace NeedLaravelSite\TikApi\Endpoints\Public;

use NeedLaravelSite\TikApi\Client\HttpClient;
use NeedLaravelSite\TikApi\Exceptions\TikApiException;

/**
 * TikAPI Public Endpoint: /public/video
 *
 * Retrieve metadata and details of a TikTok video by its ID or short link.
 *
 * @example
 * $tikapi->public()->video()->get('7003402629929913605');
 */
class Video
{
    protected HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Fetch video information by TikTok video ID or short link.
     *
     * @param string $id  TikTok video ID or short link
     * @param string|null $country Optional ISO country code (e.g. 'us', 'gb')
     *
     * @return array TikAPI JSON response
     * @throws TikApiException
     */
    public function get(string $id, ?string $country = null): array
    {
        $params = ['id' => $id];

        if ($country) {
            $params['country'] = $country;
        }

        return $this->http->request('GET', 'public/video', $params);
    }
}
