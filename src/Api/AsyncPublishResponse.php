<?php
declare(strict_types=1);

namespace PBergman\Ntfy\Api;

use PBergman\Ntfy\Model\Message;
use Symfony\Contracts\HttpClient\ResponseInterface;

class AsyncPublishResponse
{
    private \Closure $callable;
    private ResponseInterface $response;
    private ?Message $message = null;

    public function __construct(ResponseInterface $response, \Closure $callable)
    {
        $this->response = $response;
        $this->callable = $callable;
    }

    private function call(bool $unmarshall = true): ?Message
    {
        return call_user_func_array($this->callable, [$this->response, $unmarshall]);
    }

    public function wait(): Message
    {
        if (null === $this->message) {
            $this->message = $this->call();
        }

         return $this->message;
    }

    public function __invoke(): Message
    {
        return $this->wait();
    }

    public function __destruct()
    {
        if (null === $this->message) {
            $this->call(false);
        }
    }
}