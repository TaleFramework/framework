<?php declare(strict_types=1);

namespace Tale\Functional;

/**
 * @template T
 * @param iterable<T> $items
 * @return iterable<int, T>
 */
function values(iterable $items): iterable
{
    foreach ($items as $item) {
        yield $item;
    }
}
