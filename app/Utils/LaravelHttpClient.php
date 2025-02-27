<?php

namespace App\Utils;

use App\Contracts\HttpClientInterface;
use Illuminate\Http\Client\Factory as HttpClient;

class LaravelHttpClient implements HttpClientInterface
{
    public function __construct(private HttpClient $http)
    {
    }

    public function get(string $url): mixed
    {
        return $this->http->get($url);
    }
}
