<?php

declare(strict_types=1);

namespace Dadata;

class Settings
{
    const SUGGESTION_COUNT = 5;
    const TIMEOUT_SEC = 3;
    const FORMAT_JSON = 'application/json';
    const FORMAT_XML = 'application/xml';
    private string $format;
    private array $options;
    private ?string $secret;
    private string $token;

    public function __construct(string $token, ?string $secret = null, array $options = [], string $format = self::FORMAT_JSON)
    {
        $this->token = $token;
        $this->secret = $secret;
        $this->options = $options;
        $this->format = $format;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
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

    public function isJSON(): bool
    {
        return $this->getFormat() === self::FORMAT_JSON;
    }

    public function isXML(): bool
    {
        return $this->getFormat() === self::FORMAT_XML;
    }
}
