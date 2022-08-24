<?php

namespace de\interaapps\ulole\httpclient\traits;

trait HasRequestSettings {
    use HasHeaders;
    use HasQueryParameters;

    private ?int $timeout = null;
    private bool $followRedirects = true;

    public function timeout(?int $timeout): static {
        $this->timeout = $timeout;
        return $this;
    }

    public function getTimeout(): ?int {
        return $this->timeout;
    }

    public function followRedirects(): static {
        $this->followRedirects = true;
        return $this;
    }

    public function notFollowRedirects(): static {
        $this->followRedirects = false;
        return $this;
    }

    public function isFollowingRedirects(): bool {
        return $this->followRedirects;
    }


}