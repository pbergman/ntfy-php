<?php
declare(strict_types=1);

namespace PBergman\Ntfy\Model;

/**
 * @api https://ntfy.activin.nl/docs/publish/#send-http-request
 */
class HttpAction extends AbstractActionButton implements UrlActionInterface
{
    public const ACTION = 'http';
    private string $url;
    private ?string $method;
    private ?array $headers;
    private ?string $body;

    public function __construct(string $label, string $url, ?string $method = null, ?array $headers = null, ?string $body = null, ?bool $clear = null)
    {
        parent::__construct($label, $clear);

        $this->url = $url;
        $this->method = $method;
        $this->headers = $headers;
        $this->body = $body;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): HttpAction
    {
        $this->url = $url;
        return $this;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(?string $method): HttpAction
    {
        $this->method = $method;
        return $this;
    }

    public function getHeaders(): ?array
    {
        return $this->headers;
    }

    public function setHeaders(?array $headers): HttpAction
    {
        $this->headers = $headers;
        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): HttpAction
    {
        $this->body = $body;
        return $this;
    }
}