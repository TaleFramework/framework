<?php declare(strict_types=1);

namespace Tale\Functional;

function push($value, iterable $items): iterable
{
    yield from $items;
    yield $value;
}
