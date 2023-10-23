<?php
declare(strict_types=1);

namespace PBergman\Ntfy\Exception;

use PBergman\Ntfy\Api\PublishRequestContext;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class PublishException extends \Exception implements ExceptionInterface, HttpExceptionInterface
{
    private PublishRequestContext $context;
    private ResponseInterface $response;

    public function __construct(PublishRequestContext $context, ResponseInterface $response, $code = 0, \Throwable $previous = null)
    {
        $data = $response->toArray(false);

        if (isset($data['code']) && $data['error']) {
            $previous = new ErrorException($data['error'], (int)$data['code'], $data['link'] ?? '', $data['http'] ?? 0, $previous);
        }

        parent::__construct('Failed to publish message on topic \'' . $context->getTopic() . '\'', $code, $previous);

        $this->response = $response;
        $this->context  = $context;
    }

    public function getPublishContext(): PublishRequestContext
    {
        return $this->context;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}