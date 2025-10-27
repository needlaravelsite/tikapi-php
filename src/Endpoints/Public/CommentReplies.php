<?php

namespace NeedLaravelSite\TikApi\Endpoints\Public;

use NeedLaravelSite\TikApi\Client\HttpClient;
use NeedLaravelSite\TikApi\Exceptions\TikApiException;

/**
 * TikAPI Public Endpoint: /public/comment/reply/list
 *
 * Retrieve replies to a specific comment on a TikTok video.
 *
 * @example
 * $tikapi->public()->commentReplies()->list('7109178205151464746', '7109185042560680750');
 */
class CommentReplies
{
    protected HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Fetch replies to a specific TikTok comment.
     *
     * @param string $mediaId   TikTok video ID or short link
     * @param string $commentId The comment ID
     * @param int|null $count   Number of replies to return (max 30)
     * @param int|null $cursor  Pagination cursor
     * @param string|null $country ISO country code (e.g. 'us', 'ca')
     * @param int|null $sessionId Optional session ID for longer sessions
     *
     * @return array TikAPI JSON response
     * @throws TikApiException
     */
    public function list(
        string $mediaId,
        string $commentId,
        ?int $count = 30,
        ?int $cursor = null,
        ?string $country = null,
        ?int $sessionId = null
    ): array {
        $params = [
            'media_id' => $mediaId,
            'comment_id' => $commentId,
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

        return $this->http->request('GET', 'public/comment/reply/list', $params);
    }
}
