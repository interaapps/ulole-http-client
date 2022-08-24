<?php
namespace de\interaapps\ulole\httpclient\traits;

trait HasHeaders {
    private array $headers = [];



    public function getHeaders(): array {
        return $this->headers;
    }

    public function header(string $key, string $headers): static {
        $this->headers[$key] = $headers;
        return $this;
    }

    public function headers(array|null $headers): static {
        if ($headers === null)
            return $this;

        foreach ($headers as $key => $value) {
            $this->header($key, $value);
        }
        return $this;
    }

    public function setHeaders(array $headers): void {
        $this->headers = $headers;
    }

    public function getHeader(string $key): string {
        return $this->headers[$key];
    }

    public function contentType(string $type): static {
        return $this->authorization("Content-Type", $type);
    }

    public function authorization(string $type, string $token): static {
        return $this->header("Authorization", "$type $token");
    }

    public function bearer(string $token): static {
        return $this->authorization("Bearer", $token);
    }
}