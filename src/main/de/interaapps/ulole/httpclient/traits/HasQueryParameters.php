<?php
namespace de\interaapps\ulole\httpclient\traits;

trait HasQueryParameters {
    private array $queryParameters = [];

    public function query(string $key, string $query): static {
        $this->queryParameters[$key] = $query;
        return $this;
    }

    public function queries(array|null $queries): static {
        if ($queries === null)
            return $this;

        foreach ($queries as $key => $value) {
            $this->query($key, $value);
        }
        return $this;
    }

    public function getQueryParameters(): array {
        return $this->queryParameters;
    }

    public function setQueryParameters(array $queryParameters): void {
        $this->queryParameters = $queryParameters;
    }
}