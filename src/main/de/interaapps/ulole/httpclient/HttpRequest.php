<?php
namespace de\interaapps\ulole\httpclient;

use de\interaapps\ulole\httpclient\traits\HasRequestSettings;

class HttpRequest {
    use HasRequestSettings;

    private mixed $body = null;

    public function __construct(
        private HttpClient $client,
        private string     $method,
        private string     $url
    ) {
    }

    /**
     * @throws exceptions\HttpException
     */
    public function send(): HttpResponse {
        $url = $this->url;
        if (count($this->queryParameters) > 0)
            $this->url .= '?' . http_build_query($this->queryParameters);
        $res = $this->client->getAdapter()->do($this->client, $this);
        $this->url = $url;
        return $res;
    }


    public function getMethod(): string {
        return $this->method;
    }

    public function getUrl(): string {
        return $this->url;
    }

    public function body(mixed $body): HttpRequest {
        $this->body = $body;
        return $this;
    }

    public function formData(array $postFields): HttpRequest {
        $this->body = $postFields;
        $this->header("Content-Type", "multipart/form-data");
        return $this;
    }

    public function json(mixed $m): HttpRequest {
        $this->body = $this->client->getJsonPlus()->toJson($m);
        $this->header("Content-Type", "application/json");
        return $this;
    }

    public function getBody(): mixed {
        return $this->body;
    }

}