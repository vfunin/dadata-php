<?php

declare(strict_types=1);

namespace Dadata;

class Settings
{
    const SUGGESTION_COUNT = 5;
    const TIMEOUT_SEC = 3;
    private array $options;
    private ?string $secret;
    private string $token;

    public function __construct(string $token, ?string $secret = null, array $options = [])
    {
        $this->token = $token;
        $this->secret = $secret;
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return string|null
     */
    public function getSecret(): ?string
    {
        return $this->secret;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}
