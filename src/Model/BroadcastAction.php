<?php
declare(strict_types=1);

namespace PBergman\Ntfy\Model;

use PBergman\Ntfy\Util\TextUtil;

/**
 * @api https://ntfy.activin.nl/docs/publish/#send-android-broadcast
 */
class BroadcastAction extends AbstractActionButton
{
    public const ACTION = 'broadcast';
    private ?string $intent;
    private ?array $extras;

    public function __construct(string $label, ?string $intent = null, ?array $extras = null, ?bool $clear = null)
    {
        parent::__construct($label, $clear);

        $this->intent = $intent;

        if (null === $extras) {
            $this->setExtras($extras);
        }
    }

    public function getIntent(): ?string
    {
        return $this->intent;
    }

    public function setIntent(?string $intent): BroadcastAction
    {
        $this->intent = $intent;
        return $this;
    }

    public function getExtras(): ?array
    {
        return $this->extras;
    }

    public function setExtras(?array $extras): BroadcastAction
    {
        $this->extras = [];

        foreach ($extras as $name => $value) {
            $this->addExtra($name, $value);
        }

        return $this;
    }

    public function addExtra(string $name, string $value): BroadcastAction
    {
        $this->extras[$name] = $value;
        return $this;
    }
}