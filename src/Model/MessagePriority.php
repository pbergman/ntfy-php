<?php
declare(strict_types=1);

namespace PBergman\Ntfy\Model;

/**
 * @api https://ntfy.activin.nl/docs/publish/#message-priority
 */
class MessagePriority
{
    public const MAX_PRIORITY       = 0x05;
    public const HIGH_PRIORITY      = 0x04;
    public const DEFAULT_PRIORITY   = 0x03;
    public const LOW_PRIORITY       = 0x02;
    public const MIN_PRIORITY       = 0x01;
}