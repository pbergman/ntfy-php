<?php
declare(strict_types=1);

namespace PBergman\Ntfy\Encoding;

use PBergman\Ntfy\Model\ParametersInterface;
use PBergman\Ntfy\Model\Message;

interface MarshallerInterface
{
    public function marshall(ParametersInterface $message, array $ctx = []): array;

    public function unmarshall(array $data, array $ctx = []): Message;
}