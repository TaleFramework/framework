<?php declare(strict_types=1);

namespace Tale\Functional;

/**
 * @template T
 *
 * @param callable $fn
 * @param iterable<T> $items
 * @return T|null
 */
function find(callable $fn, iterable $items): mixed
{
    foreach ($items as $item) {
        if ($fn($item)) {
            return $item;
        }
    }
    return null;
}
