<?php
declare(strict_types=1);

namespace PBergman\Ntfy\Model;

interface UrlActionInterface
{
    public function getUrl(): string;
}