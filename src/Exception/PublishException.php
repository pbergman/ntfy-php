<?php
declare(strict_types=1);

namespace PBergman\Ntfy\Exception;

use PBergman\Ntfy\Model\PublishParameters;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class PublishException extends \Exception implements ExceptionInterface, HttpExceptionInterface
{
    private PublishParameters $parameters;
    private ResponseInterface $response;

    public function __construct(PublishParameters $parameters, ResponseInterface $response, string $topic, $code = 0, \Throwable $previous = null)
    {
        parent::__construct('Failed to publish message on topic \'' . $topic . '\'', $code, $previous);
        $this->response   = $response;
        $this->parameters = $parameters;
    }

    public function getMessageParameters(): PublishParameters
    {
        return $this->parameters;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}