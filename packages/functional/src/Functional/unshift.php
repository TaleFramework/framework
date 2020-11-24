<?php declare(strict_types=1);

namespace Tale\Functional;

function unshift($value, iterable $items): iterable
{
    yield $value;
    yield from $items;
}
