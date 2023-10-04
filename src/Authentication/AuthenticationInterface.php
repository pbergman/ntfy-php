<?php
declare(strict_types=1);

namespace PBergman\Ntfy\Authentication;

interface AuthenticationInterface
{
    public function set(array &$options);
}
