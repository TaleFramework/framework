<?php declare(strict_types=1);

namespace Tale\Functional;

use JetBrains\PhpStorm\Pure;

/**
 * @template T
 * @param iterable<T> $value
 * @return array<T>
 */
#[Pure]
function unwind(iterable $value): array
{
    return $value instanceof \Traversable ? iterator_to_array($value) : (array)$value;
}
