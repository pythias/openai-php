<?php

declare(strict_types=1);

namespace OpenAI\Responses\Concerns;

use BadMethodCallException;
use OpenAI\Contracts\Response;

/**
 * @template TArray of array
 *
 * @mixin Response<TArray>
 */
trait ArrayAccessible {
    /**
     * {@inheritDoc}
     */
    public function offsetExists($offset): bool {
        return array_key_exists($offset, $this->toArray());
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet($offset) {
        return $this->toArray()[$offset];
    }

    /**
     * {@inheritDoc}
     * @return never
     */
    public function offsetSet($offset, $value): void {
        throw new BadMethodCallException('Cannot set response attributes.');
    }

    /**
     * {@inheritDoc}
     * @return never
     */
    public function offsetUnset($offset): void {
        throw new BadMethodCallException('Cannot unset response attributes.');
    }
}
