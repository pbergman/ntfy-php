<?php
declare(strict_types=1);

namespace PBergman\Ntfy\Model;

/**
 * @api https://ntfy.activin.nl/docs/publish/#open-websiteapp
 */
class ViewAction extends AbstractActionButton implements UrlActionInterface
{
    public const ACTION = 'view';

    private string $url;

    public function __construct(string $label, string $url, ?bool $clear = null)
    {
        parent::__construct($label, $clear);
        $this->url   = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): ViewAction
    {
        $this->url = $url;
        return $this;
    }
}