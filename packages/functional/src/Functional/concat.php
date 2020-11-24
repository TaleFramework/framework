<?php declare(strict_types=1);

namespace Tale\Functional;

/**
 * @template T
 *
 * @param iterable<T> $items
 * @param iterable ...$additionalItemSets
 * @return iterable
 */
function concat(iterable $items, iterable ...$additionalItemSets): iterable
{
    yield from $items;
    foreach ($additionalItemSets as $additionalItems) {
        yield from $additionalItems;
    }
}
