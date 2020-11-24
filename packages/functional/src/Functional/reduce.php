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
function reduce(callable $fn, mixed $initialValue, iterable $items): iterable
{
    $carry = $initialValue;
    foreach ($items as $item) {
        $carry = $fn($carry, $item);
    }
    return $carry;
}
