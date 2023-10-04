<?php
declare(strict_types=1);

namespace PBergman\Ntfy\Api;

use PBergman\Ntfy\Model\Message;
use Symfony\Contracts\HttpClient\ResponseInterface;

class AsyncPublishResponse
{
    private \Closure $callable;
    private ResponseInterface $response;

    public function __construct(ResponseInterface $response, \Closure $callable)
    {
        $this->response = $response;
        $this->callable = $callable;
    }

    public function __invoke(): Message
    {
        return call_user_func_array($this->callable, [$this->response]);
    }
}