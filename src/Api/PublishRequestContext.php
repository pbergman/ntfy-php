<?php
declare(strict_types=1);

namespace PBergman\Ntfy\Api;

use PBergman\Ntfy\Model\PublishParameters;

class PublishRequestContext
{
    private string $topic;
    private ?PublishParameters $parameters;

    public function __construct(string $topic, ?PublishParameters $parameters)
    {
        $this->topic = $topic;
        $this->parameters = $parameters;
    }

    public function getTopic(): string
    {
        return $this->topic;
    }

    public function getParameters(): ?PublishParameters
    {
        return $this->parameters;
    }
}