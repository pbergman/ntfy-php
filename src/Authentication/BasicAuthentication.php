<?php
declare(strict_types=1);

namespace PBergman\Ntfy\Authentication;

class BasicAuthentication implements AuthenticationInterface
{
    private string $username;
    private string $password;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function set(array &$options)
    {
        if (false === array_key_exists('auth_basic', $options)) {
            $options['auth_basic'] = [
                $this->username,
                $this->password,
            ];
        }
    }
}