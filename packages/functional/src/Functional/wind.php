<?php declare(strict_types=1);

namespace Tale\Functional;

use ArrayIterator;

function wind(iterable $value): iterable
{
    return $value instanceof \Traversable ? $value : new ArrayIterator((array)$value);
}
