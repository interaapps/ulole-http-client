<?php

namespace de\interaapps\ulole\httpclient;

class HttpResponse {

    public function __construct(
        private HttpClient $client,
        private int $status,
        private mixed $body,
        private array $headers
    ) {
    }

    public function body(): mixed {
        return $this->body;
    }

    public function json(string|null $type = null): mixed {
        return $this->client->getJsonPlus()->fromJson($this->body(), $type);
    }

    public function status(): int {
        return $this->status;
    }


    public function ok(): bool {
        return $this->status >= 200 && $this->status < 400;
    }

    public function header(string $key): mixed {
        return $this->headers[$key];
    }

    public function headers(): array {
        return $this->headers;
    }

    public function getClient(): HttpClient {
        return $this->client;
    }
}