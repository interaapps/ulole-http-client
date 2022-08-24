<?php
namespace de\interaapps\ulole\httpclient;

use de\interaapps\jsonplus\JSONPlus;
use de\interaapps\ulole\httpclient\http\CURLHttpAdapter;
use de\interaapps\ulole\httpclient\http\HttpAdapter;
use de\interaapps\ulole\httpclient\traits\HasRequestSettings;

class HttpClient {
    use HasRequestSettings;

    public static HttpAdapter $adapterDefault;
    public static JSONPlus $jsonPlusDefault;

    private HttpAdapter $adapter;
    private string $baseUrl = "";
    public JSONPlus $jsonPlus;

    public function __construct() {
    }

    public function request(string $method, string $url): HttpRequest {
        $this->adapter = HttpClient::$adapterDefault;
        $this->jsonPlus = HttpClient::$jsonPlusDefault;

        $req = new HttpRequest($this, $this->baseUrl . $method, $url);
        $req->headers($this->headers);
        $req->queries($this->queryParameters);
        $req->timeout($this->timeout);
        return $req;
    }

    public function get(string $url, array|null $query = null): HttpRequest {
        return $this->request("GET", $url)->queries($query);
    }

    public function delete(string $url, array|null $query = null): HttpRequest {
        return $this->request("DELETE", $url)->queries($query);
    }

    public function head(string $url, array|null $query = null): HttpRequest {
        return $this->request("HEAD", $url)->queries($query);
    }

    public function post(string $url, mixed $body = null): HttpRequest {
        return $this->request("POST", $url)->json($body);
    }

    public function put(string $url, mixed $body = null): HttpRequest {
        return $this->request("POST", $url)->json($body);
    }

    public function patch(string $url, mixed $body = null): HttpRequest {
        return $this->request("PATCH", $url)->json($body);
    }

    public function getAdapter(): HttpAdapter {
        return $this->adapter;
    }

    public function getJsonPlus(): JSONPlus {
        return $this->jsonPlus;
    }
}

HttpClient::$adapterDefault = new CURLHttpAdapter();
HttpClient::$jsonPlusDefault = JSONPlus::$default;