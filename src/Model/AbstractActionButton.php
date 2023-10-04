<?php
declare(strict_types=1);

namespace PBergman\Ntfy\Model;

use PBergman\Ntfy\Util\TextUtil;

/**
 * @api https://ntfy.activin.nl/docs/publish/#action-buttons
 */
abstract class AbstractActionButton
{
    public const ACTION = self::ACTION;

    protected ?string $id;
    protected string $label;
    protected ?bool $clear;

    public function __construct(string $label, ?bool $clear = null)
    {
        $this->label = $label;
        $this->clear = $clear;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): AbstractActionButton
    {
        $this->label = $label;
        return $this;
    }


    public function getClear(): ?bool
    {
        return $this->clear;
    }

    public function setClear(?bool $clear): AbstractActionButton
    {
        $this->clear = $clear;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): AbstractActionButton
    {
        $this->id = $id;
        return $this;
    }

    public function __toString(): string
    {
        $str = $this::ACTION . ', ' . TextUtil::quote($this->getLabel());

        if ($this instanceof UrlActionInterface) {
            $str .= ', ' . $this->getUrl();
        }

        if ($this instanceof HttpAction) {
            if (null !== $value = $this->getMethod()) {
                $str .= ', method=' . $value;
            }
            foreach ((array)$this->getHeaders() as $key => $value) {
                $str .= ', headers.' . TextUtil::validActionKey($key) . '=' . $value;
            }
            if (null !== $value = $this->getBody()) {
                $str .= ', body=' . $value;
            }
        }
        if ($this instanceof BroadcastAction) {
            if (null !== $value = $this->getIntent()) {
                $str .= ', intent=' . $value;
            }
            foreach ((array)$this->getExtras() as $key => $value) {
                $str .= ', extras.' . TextUtil::validActionKey($key) . '=' . $value;
            }
        }
        if (null !== $value = $this->getClear()) {
            $str .= ', clear=' . ($value ? '1' : '0');
        }

        return $str;
    }
}