<?php
declare(strict_types=1);

namespace PBergman\Ntfy\Model;

use PBergman\Ntfy\Util\TextUtil;
use Traversable;

class ActionCollection implements \ArrayAccess, \Countable, \IteratorAggregate
{
    private array $actions = [];

    public function offsetExists($offset): bool
    {
        return \array_key_exists($offset, $this->actions);
    }

    public function offsetGet($offset): ?AbstractActionButton
    {
        return $this->actions[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        $this->actions[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset(
            $this->actions[$offset]
        );
    }

    public function getIterator()
    {
        foreach ($this->actions as $action) {
            yield $action;
        }
    }

    public function count()
    {
        return \count($this->actions);
    }


}