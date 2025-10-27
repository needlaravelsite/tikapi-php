<?php

namespace NeedLaravelSite\TikApi\Endpoints\Public;

use NeedLaravelSite\TikApi\Client\HttpClient;
use NeedLaravelSite\TikApi\Exceptions\TikApiException;

/**
 * TikAPI Public Endpoint: /public/search/{category}
 *
 * Perform searches across TikTok for users, videos, or general results.
 *
 * @example
 * $tikapi->public()->search()->general('lilyachty');
 * $tikapi->public()->search()->users('lilyachty');
 * $tikapi->public()->search()->videos('funny');
 */
class Search
{
    protected HttpClient $http;

    /**
     * Supported TikAPI search categories.
     */
    protected const CATEGORIES = ['general', 'users', 'videos', 'autocomplete'];

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Perform a TikAPI search request.
     *
     * @param string $category One of "general", "users", "videos", or "autocomplete".
     * @param string $query Search term or keyword.
     * @param string|null $nextCursor Pagination cursor for the next request.
     * @param string|null $country Optional ISO country code (e.g. 'us', 'ca').
     *
     * @return array TikAPI JSON response.
     * @throws TikApiException
     */
    public function perform(
        string $category,
        string $query,
        ?string $nextCursor = null,
        ?string $country = null
    ): array {
        if (!in_array($category, self::CATEGORIES, true)) {
            throw new TikApiException("Invalid search category '{$category}'. Must be one of: " . implode(', ', self::CATEGORIES));
        }

        $params = ['query' => $query];

        if ($nextCursor) {
            $params['nextCursor'] = $nextCursor;
        }

        if ($country) {
            $params['country'] = $country;
        }

        return $this->http->request('GET', "public/search/{$category}", $params);
    }

    // Convenience wrappers

    /**
     * @throws TikApiException
     */
    public function general(string $query, ?string $country = null): array
    {
        return $this->perform('general', $query, null, $country);
    }

    /**
     * @throws TikApiException
     */
    public function users(string $query, ?string $country = null): array
    {
        return $this->perform('users', $query, null, $country);
    }

    /**
     * @throws TikApiException
     */
    public function videos(string $query, ?string $country = null): array
    {
        return $this->perform('videos', $query, null, $country);
    }

    /**
     * @throws TikApiException
     */
    public function autocomplete(string $query, ?string $country = null): array
    {
        return $this->perform('autocomplete', $query, null, $country);
    }
}
