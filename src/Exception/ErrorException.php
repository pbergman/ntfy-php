<?php
declare(strict_types=1);

namespace PBergman\Ntfy\Exception;

class ErrorException extends \Exception implements ExceptionInterface
{
    private int $http;
    private string $link;

    public function __construct(string $message, int $code, string $link, int $http, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->http = $http;
        $this->link = $link;
    }

    public function getHttp(): int
    {
        return $this->http;
    }

    public function getLink(): string
    {
        return $this->link;
    }
}