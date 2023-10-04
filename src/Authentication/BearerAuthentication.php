<?php
declare(strict_types=1);

namespace PBergman\Ntfy\Authentication;

class BearerAuthentication implements AuthenticationInterface
{
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function set(array &$options)
    {
        if (false === array_key_exists('auth_bearer', $options)) {
            $options['auth_bearer'] = $this->token;
        }
    }
}