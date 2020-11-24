<?php declare(strict_types=1);

namespace Tale\Functional;

/**
 * @template T
 * @template R
 * @param callable $fn
 * @param R $initialValue
 * @param iterable<T> $items
 * @return iterable<R>
 */
function reduce_right(callable $fn, $initialValue, iterable $items): iterable
{
    $reversedItems = array_reverse(unwind($items), false);
    $carry = $initialValue;
    foreach ($reversedItems as $item) {
        $carry = $fn($carry, $item);
    }
    return $carry;
}
