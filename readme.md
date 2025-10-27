# needlaravelsite/tikapi-php

TikAPI SDK for **plain PHP** and **Laravel**, created and maintained by **NeedLaravelSite**.

---

## 🚀 Overview
This SDK provides a clean, scalable, and framework-agnostic wrapper for the [TikAPI](https://www.tikapi.io/documentation/) — making it easy to fetch TikTok data via PHP or Laravel.

✅ Works in **plain PHP**  
✅ Fully integrated with **Laravel** (Service Provider + Facade)  
✅ Built on **Guzzle**  
✅ Auto-loads API keys from `.env`  
✅ **PSR-4** and **PSR-12** compliant  
✅ Includes **feature tests** for all public endpoints

---

## 🧰 Installation

```bash
composer require needlaravelsite/tikapi-php
```

> Requires **PHP 8.0+**

---

## ⚙️ Laravel Setup

### 1. Publish Configuration
```bash
php artisan vendor:publish --provider="NeedLaravelSite\\TikApi\\TikApiServiceProvider" --tag=config
```

### 2. Add Environment Variables
```dotenv
TIKAPI_API_KEY=your_api_key_here
TIKAPI_ACCOUNT_KEY=your_account_key_if_any
TIKAPI_BASE_URL=https://api.tikapi.io
```

If any of these values are missing, the SDK safely defaults to environment values or fallback URLs.

---

## 🧱 Project Structure

```
src/
├── Client/
│   └── HttpClient.php
├── Endpoints/
│   └── Public/
│        ├── Check.php
│        ├── CommentReplies.php
│        ├── Comments.php
│        ├── Explore.php
│        ├── Followers.php
│        ├── Following.php
│        ├── Hashtag.php
│        ├── Likes.php
│        ├── Music.php
│        ├── MusicInfo.php
│        ├── Posts.php
│        ├── Search.php
│        └── Video.php
├── Exceptions/
│   └── TikApiException.php
├── Facades/
│   ├── TikApi.php
│   └── TikApiServiceProvider.php
└── TikApi.php
```

---

## 🧩 Usage Examples

### ✅ In Laravel (via Facade or DI)

**Using the Facade:**
```php
use TikApi;

$response = TikApi::public()->explore()->list(5, 'us');
```

**Using Dependency Injection:**
```php
use NeedLaravelSite\TikApi\TikApi;

class TikApiController
{
    public function index(TikApi $tikapi)
    {
        return $tikapi->public()->video()->get('7109178205151464746');
    }
}
```

---

### ✅ In Plain PHP

```php
<?php

require 'vendor/autoload.php';

use NeedLaravelSite\TikApi\TikApi;

$tikapi = new TikApi();

$response = $tikapi->public()->check()->username('lilyachty');
print_r($response);
```

Or provide credentials manually:
```php
$tikapi = new TikApi('your_api_key', 'optional_account_key', 'https://api.tikapi.io');
```

---

## 🔍 Available Endpoints

| Endpoint | Class | Description |
|-----------|--------|-------------|
| `/public/check` | `Check` | Verify TikAPI connectivity or get public user data |
| `/public/posts` | `Posts` | Get posts by a TikTok user |
| `/public/likes` | `Likes` | Get liked videos for a user |
| `/public/followers` | `Followers` | Get a user's followers |
| `/public/following` | `Following` | Get accounts followed by a user |
| `/public/explore` | `Explore` | Get trending TikTok posts ("For You" feed) |
| `/public/video` | `Video` | Get TikTok video details by ID |
| `/public/hashtag` | `Hashtag` | Get posts by hashtag name or ID |
| `/public/comment/list` | `Comments` | Get comments under a video |
| `/public/comment/reply/list` | `CommentReplies` | Get replies to a comment |
| `/public/music` | `Music` | Get posts using a specific sound |
| `/public/music/info` | `MusicInfo` | Get sound metadata (title, author, duration) |
| `/public/search/{category}` | `Search` | Search users, videos, or keywords |

---

## 🧠 Example API Calls

```php
$tikapi = new TikApi();

// 1️⃣ Get trending posts
$tikapi->public()->explore()->list(10, 'us');

// 2️⃣ Fetch posts by hashtag
$tikapi->public()->hashtag()->list(name: 'funny', count: 10);

// 3️⃣ Get video info
$tikapi->public()->video()->get('7109178205151464746', 'us');

// 4️⃣ Get comments and replies
$tikapi->public()->comments()->list('7109178205151464746');
$tikapi->public()->commentReplies()->list('7109178205151464746', '7109185042560680750');

// 5️⃣ Get music information
$tikapi->public()->musicInfo()->get('28459463');

// 6️⃣ Perform a search
$tikapi->public()->search()->general('lilyachty', 'us');
```

---

## 🧪 Testing

### Run All Tests
```bash
vendor/bin/phpunit
```

### Run Specific Test File
```bash
vendor/bin/phpunit tests/Feature/Public/SearchIntegrationTest.php
```

### Run Specific Method
```bash
vendor/bin/phpunit --filter testPublicSearchGeneralReturnsSuccess
```

> Integration tests require a valid `TIKAPI_API_KEY` in your `.env` file.

---

## 🧰 Error Handling

All errors are thrown as `TikApiException` for consistent handling.

```php
use NeedLaravelSite\TikApi\Exceptions\TikApiException;

try {
    $response = $tikapi->public()->video()->get('7109178205151464746');
} catch (TikApiException $e) {
    echo 'TikAPI Error: ' . $e->getMessage();
}
```

---

## 🤝 Contributing

Contributions are welcome under the **NeedLaravelSite** organization.

### Guidelines
- Follow **PSR-12** coding standards
- Add or update feature tests for new endpoints
- Update README when adding new functionality

---

## 📜 License

**MIT License © 2025**  
Built by [Muhammad Waqas](https://github.com/mwaqasiu) at [NeedLaravelSite](https://needlaravelsite.com)

