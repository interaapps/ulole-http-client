<?php
namespace de\interaapps\ulole\httpclient\http;

use de\interaapps\ulole\httpclient\exceptions\HttpException;
use de\interaapps\ulole\httpclient\HttpClient;
use de\interaapps\ulole\httpclient\HttpRequest;
use de\interaapps\ulole\httpclient\HttpResponse;

interface HttpAdapter {
    /**
     * @throws HttpException
     */
    public function do(HttpClient $client, HttpRequest $request): HttpResponse;
}