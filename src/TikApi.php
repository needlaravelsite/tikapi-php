<?php

namespace NeedLaravelSite\TikApi;

use GuzzleHttp\Client as GuzzleClient;
use NeedLaravelSite\TikApi\Client\HttpClient;
use NeedLaravelSite\TikApi\Endpoints\Public\Check;
use NeedLaravelSite\TikApi\Endpoints\Public\CommentReplies;
use NeedLaravelSite\TikApi\Endpoints\Public\Comments;
use NeedLaravelSite\TikApi\Endpoints\Public\Explore;
use NeedLaravelSite\TikApi\Endpoints\Public\Followers;
use NeedLaravelSite\TikApi\Endpoints\Public\Following;
use NeedLaravelSite\TikApi\Endpoints\Public\Hashtag;
use NeedLaravelSite\TikApi\Endpoints\Public\Likes;
use NeedLaravelSite\TikApi\Endpoints\Public\Music;
use NeedLaravelSite\TikApi\Endpoints\Public\MusicInfo;
use NeedLaravelSite\TikApi\Endpoints\Public\Posts;
use NeedLaravelSite\TikApi\Endpoints\Public\Search;
use NeedLaravelSite\TikApi\Endpoints\Public\Video;

class TikApi
{
    protected HttpClient $http;

    /**
     * Create a new TikApi instance.
     *
     * @param string|null $apiKey TikAPI key (optional)
     * @param string|null $accountKey Optional account key for authenticated endpoints
     * @param string|null $baseUrl Base URL (default: https://api.tikapi.io)
     */
    public function __construct(
        ?string $apiKey = null,
        ?string $accountKey = null,
        ?string $baseUrl = null
    )
    {
        // 1️⃣ Load from environment if not provided
        $apiKey = $apiKey ?? ($_ENV['TIKAPI_API_KEY'] ?? null);
        $accountKey = $accountKey ?? ($_ENV['TIKAPI_ACCOUNT_KEY'] ?? null);
        $baseUrl = $baseUrl ?? ($_ENV['TIKAPI_BASE_URL'] ?? 'https://api.tikapi.io');

        if (!$apiKey) {
            trigger_error('[TikApi] Warning: No API key provided. Requests may fail if endpoint requires authentication.', E_USER_WARNING);
        }

        // 2️⃣ Initialize base HTTP transport
        $guzzle = new GuzzleClient();
        $this->http = new HttpClient($guzzle, $apiKey, $accountKey, $baseUrl);
    }

    // -----------------------------------------------------
    // Public endpoints
    // -----------------------------------------------------

    public function public(): object
    {
        return new class($this->http) {
            protected HttpClient $http;

            public function __construct(HttpClient $http)
            {
                $this->http = $http;
            }

            public function check(): Check
            {
                return new Check($this->http);
            }

            public function posts(): Posts
            {
                return new Posts($this->http);
            }

            public function likes(): Likes
            {
                return new Likes($this->http);
            }

            public function followers(): Followers
            {
                return new Followers($this->http);
            }

            public function following(): Following
            {
                return new Following($this->http);
            }

            public function explore(): Explore
            {
                return new Explore($this->http);
            }

            public function video(): Video
            {
                return new Video($this->http);
            }

            public function hashtag(): Hashtag
            {
                return new Hashtag($this->http);
            }

            public function comments(): Comments
            {
                return new Comments($this->http);
            }

            public function commentReplies(): CommentReplies
            {
                return new CommentReplies($this->http);
            }

            public function music(): Music
            {
                return new Music($this->http);
            }

            public function musicInfo(): MusicInfo
            {
                return new MusicInfo($this->http);
            }

            public function search(): Search
            {
                return new Search($this->http);
            }
        };
    }
}
